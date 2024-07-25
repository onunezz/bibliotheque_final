<?php

class EditorialModel
{
    static public function getAllEditorials()
    {
        $sql = "SELECT
        editorials.id AS id_editorial,
        editorials.name AS name,
        editorials.state AS state
        FROM
        editorials";

        $stmt = MysqlDb::connect()->prepare($sql);

        if ($stmt->execute()) {

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {

            print_r($stmt->errorInfo());
        }

        $stmt = null;
    }

    static public function newEditorial($value1)
    {
        $sql = "INSERT INTO editorials (name, state)
                VALUES (:name, 1);";

        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(':name', $value1, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            print_r($stmt->errorInfo());
        }
    }
}
