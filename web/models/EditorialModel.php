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
            $editorials = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
            return $editorials;
        } else {
            print_r($stmt->errorInfo());
            $stmt = null;
            return [];
        }
    }

    static public function getAllActiveEditorials()
    {
        $sql = "SELECT
        editorials.id AS id_editorial,
        editorials.name AS name,
        editorials.state AS state
        FROM
        editorials
        WHERE
        editorials.state = 1;";

        $stmt = MysqlDb::connect()->prepare($sql);

        if ($stmt->execute()) {
            $editorials = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
            return $editorials;
        } else {
            print_r($stmt->errorInfo());
            $stmt = null;
            return [];
        }
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

    static public function checkDuplicates($value1)
    {
        try {
            $query = "SELECT COUNT(*) FROM editorials WHERE name = ?;";
            $checkStatement = MysqlDb::connect()->prepare($query);
            $checkStatement->bindParam(1, $value1, PDO::PARAM_STR);
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

    public static function checkDuplicatesForUpdate($name, $id)
    {
        $stmt = MysqlDb::connect()->prepare("SELECT COUNT(*) FROM editorials WHERE name = :name AND id != :id");
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0 ? true : false;
    }

    public static function updateEditorial($id, $name)
    {
        $stmt = MysqlDb::connect()->prepare("UPDATE editorials SET name = :name WHERE id = :id");
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function disableEditorial($id)
    {
        $sql = "UPDATE editorials SET state = 2 WHERE id = ?;";
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

    public static function enableEditorial($id)
    {
        $sql = "UPDATE editorials SET state = 1 WHERE id = ?;";
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
