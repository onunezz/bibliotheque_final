<?php
class UserModel
{
    static public function login($email, $password)
    {
        $query = "SELECT id, email, dni, password, change_password, fk_role_id, state
          FROM users WHERE email = :email";

        $statement = MysqlDb::connect()->prepare($query);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if (password_verify($password, $row['password'])) {
                return $row;
            }
        }

        return false;
    }

    static public function dataUser($id)
    {
        $sql = "SELECT
                 users.id AS id_user,
                 users.name AS name_user,
                 users.last_name AS last_name_user,
                 users.email AS email,
                 users.dni AS dni,
                 users.password AS password, 
                 users.change_password AS change_password,
                 users.state AS state,              
                 users.fk_role_id AS fk_role_id,
                 roles.description AS description_role
             FROM 
                 users
             JOIN 
                 roles ON users.fk_role_id = roles.id
             WHERE 
                 users.id = ?";

        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            print_r($stmt->errorInfo());
        }

        $stmt = null;
    }

    static public function getAllUsers()
    {
        $sql = "SELECT 
        users.id AS id_user,
        users.last_name AS last_name,
        users.name AS name,
        users.dni AS dni,
        users.fk_role_id AS fk_role_id,
        users.email AS email,
        users.state AS state
        FROM
        users;";

        $stmt = MysqlDb::connect()->prepare($sql);

        if ($stmt->execute()) {
            $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
            return $authors;
        } else {
            print_r($stmt->errorInfo());
            $stmt = null;
            return [];
        }
    }

    static  public function checkForDuplicates($value1, $value2)
    {
        try {
            $checkQuery = "SELECT COUNT(*) FROM users WHERE dni = ? OR email = ? ";
            $checkStatement = MysqlDb::connect()->prepare($checkQuery);
            $checkStatement->bindParam(1, $value1, PDO::PARAM_STR);
            $checkStatement->bindParam(2, $value2, PDO::PARAM_STR);
            $checkStatement->execute();

            $count = $checkStatement->fetchColumn();

            if ($count > 0) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            echo "Error en la validación de duplicados: " . $e->getMessage();
            return false;
        }
    }

    static public function newuser($last_name, $name, $dni, $fk_role_id, $email, $hashedPassword)
    {
        $sql = "INSERT INTO users (last_name, name, dni, fk_role_id, email, password)
                VALUES (:last_name, :name, :dni, :fk_role_id, :email, :password);";

        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':dni', $dni, PDO::PARAM_INT);
        $stmt->bindParam(':fk_role_id', $fk_role_id, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            print_r($stmt->errorInfo());
        }
    }

    static public function updateUser($id, $last_name, $name, $fk_role_id)
    {
        $sql = "UPDATE users
        SET last_name = :last_name, name = :name,
            fk_role_id = :fk_role_id
        WHERE id = :id";

        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':fk_role_id', $fk_role_id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            print_r($stmt->errorInfo());
        }

        $stmt = null;
    }

    static public function changePasswordStart($id, $newPassword)
    {
        $sql = "UPDATE users SET password = ?, change_password = 1 WHERE id = ?";

        $stmt = MysqlDb::connect()->prepare($sql);


        $stmt->bindParam(1, $newPassword, PDO::PARAM_STR);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);


        if ($stmt->execute()) {
            return true;
        } else {
            print_r($stmt->errorInfo());
        }

        $stmt = null;
    }

    static public function updateChangedPassword($id)
    {
        $sql = "UPDATE users SET change_password = 0 WHERE id = ?";
        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            print_r($stmt->errorInfo());
            return false;
        }
        $stmt = null;
    }

    static public function updateNewPassword($password, $id)
    {
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(1, $password, PDO::PARAM_STR);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            print_r($stmt->errorInfo());
            return false;
        }
        $stmt = null;
    }

    static public function disableUser($id)
    {
        $sql = "UPDATE users SET state = 2 WHERE id = ?";
        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            print_r($stmt->errorInfo());
            return false;
        }
        $stmt = null;
    }

    static public function activateUser($id)
    {
        $sql = "UPDATE users SET state = 1 WHERE id = ?";
        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        } else {
            print_r($stmt->errorInfo());
            return false;
        }
        $stmt = null;
    }
}
