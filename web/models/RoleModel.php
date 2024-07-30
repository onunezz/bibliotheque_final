<?php

class RoleModel
{
    static public function getAllRoles()
    {
        $sql = "SELECT 
        roles.id AS id_role,
        roles.description AS description
        FROM
        roles;";

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
