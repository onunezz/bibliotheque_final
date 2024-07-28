<?php

class CategoryModel
{
    static public function getAllCategories()
    {
        $sql = "SELECT 
        categories.id AS id_category,
        categories.description AS description
        FROM 
        categories;";

        $stmt = MysqlDb::connect()->prepare($sql);

        if ($stmt->execute()) {
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
            return $categories;
        } else {
            print_r($stmt->errorInfo());
            $stmt = null;
            return [];
        }
    }
}
