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
}
