<?php
class UserModel
{
    static public function login($email, $password)
    {
        $query = "SELECT id, email, dni, password, fk_role_id, state
          FROM users WHERE email = :email";

        $statement = MysqlDb::connect()->prepare($query);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if ($password === $row['password']) {
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
                 users.state AS state,              
                 users.fk_role_id AS id_role,
                 roles.name AS name_role
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
}
