<?php

class ClientModel
{
    static public function getAllClients()
    {
        $sql = "SELECT 
        clients.id AS id_client,
        clients.last_name AS last_name,
        clients.name AS name,
        clients.dni AS dni,
        clients.address AS address,
        clients.email AS email,
        clients.state AS state
        FROM
        clients;";

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

    static public function getAllActiveClients()
    {
        $sql = "SELECT 
        clients.id AS id_client,
        clients.last_name AS last_name,
        clients.name AS name,
        clients.dni AS dni,
        clients.address AS address,
        clients.email AS email,
        clients.state AS state
        FROM
        clients
        WHERE 
        clients.state = 1;";

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
            $checkQuery = "SELECT COUNT(*) FROM clients WHERE dni = ? OR email = ? ";
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

    static public function newClient($last_name, $name, $dni, $address, $email)
    {
        $sql = "INSERT INTO clients (last_name, name, dni, address, email)
                VALUES (:last_name, :name, :dni, :address, :email);";

        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':dni', $dni, PDO::PARAM_INT);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            print_r($stmt->errorInfo());
        }
    }

    static public function newClientQuick($last_name, $dni, $email)
    {
        $sql = "INSERT INTO clients (last_name, dni, email) VALUES (:last_name, :dni, :email);";
        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':dni', $dni, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            print_r($stmt->errorInfo());
        }
    }


    static public function updateClient($id, $last_name, $name, $address)
    {
        $sql = "UPDATE clients
        SET last_name = :last_name, name = :name,
            address = :address
        WHERE id = :id";

        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            print_r($stmt->errorInfo());
        }

        $stmt = null;
    }

    static public function enableClient($id)
    {
        $sql = "UPDATE clients SET state = 1 WHERE id = ?;";
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

    public static function disableClient($id)
    {
        $sql = "UPDATE clients SET state = 2 WHERE id = ?;";
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
