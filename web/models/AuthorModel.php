<?php

class AuthorModel
{
    static public function getAllAuthors()
    {
        $sql = "SELECT
        authors.id AS id_author,
        authors.name AS name,
        authors.last_name AS last_name,
        authors.fk_nationality_id AS fk_nationality_id,
        nationalities.id AS id_nationality,
        nationalities.country AS country
        FROM
        authors
        LEFT JOIN 
        nationalities ON authors.fk_nationality_id = nationalities.id;";

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


    static public function newAuthor($value1, $value2, $value3)
    {
        $sql = "INSERT INTO authors (name, last_name, fk_nationality_id)
                VALUES (:name, :last_name, :fk_nationality_id);";

        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(':name', $value1, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $value2, PDO::PARAM_STR);
        $stmt->bindParam(':fk_nationality_id', $value3, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            print_r($stmt->errorInfo());
        }
    }

    public static function checkDuplicates($name, $lastName)
    {
        try {
            $query = "SELECT COUNT(*) FROM authors WHERE name = ? AND last_name = ?;";
            $checkStatement = MysqlDb::connect()->prepare($query);
            $checkStatement->bindParam(1, $name, PDO::PARAM_STR);
            $checkStatement->bindParam(2, $lastName, PDO::PARAM_STR);
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

    static public function updateAuthor($id, $name, $last_name, $fk_nationality_id)
    {
        $sql = "UPDATE authors 
            SET name = :name, last_name = :last_name, fk_nationality_id = :fk_nationality_id 
            WHERE id = :id";

        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':fk_nationality_id', $fk_nationality_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            print_r($stmt->errorInfo());
        }

        $stmt = null;
    }
}
