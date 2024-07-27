<?php
class NationalityModel
{
    static public function getAllNationalities()
    {
        $sql = "SELECT
        nationalities.id AS id_nationality,
        nationalities.country AS country
        FROM
        nationalities;";

        $stmt = MysqlDb::connect()->prepare($sql);

        if ($stmt->execute()) {

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {

            print_r($stmt->errorInfo());
        }

        $stmt = null;
    }

    static public function newNationality($value)
    {
        $sql = "INSERT INTO nationalities (country)
                VALUES (:country);";

        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(':country', $value, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            print_r($stmt->errorInfo());
        }
    }

    public static function checkNationalityDuplicates($country)
    {
        try {
            $query = "SELECT COUNT(*) FROM nationalities WHERE country = ?;";
            $checkStatement = MysqlDb::connect()->prepare($query);
            $checkStatement->bindParam(1, $country, PDO::PARAM_STR);
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
}
