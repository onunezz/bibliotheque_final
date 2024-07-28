<?php

class BookModel
{
    static public function getAllBooks()
    {
        $sql = "SELECT
        books.id AS id_book,
        books.title AS title,
        books.fk_author_id AS fk_author_id,
        books.fk_editorial_id AS fk_editorial_id,
        books.fk_category_id AS fk_category_id,
        books.amount AS amount,
        books.publication_date AS publication_date,
        books.abbreviature AS abbreviature,
        authors.id AS id_author,
        authors.name AS name_author,
        authors.last_name AS last_name_author,
        editorials.id AS id_editorial,
        editorials.name AS name_editorial,
        categories.id AS id_category,
        categories.description AS description_category
        FROM
        books
        LEFT JOIN 
        authors ON books.fk_author_id = authors.id
        LEFT JOIN
        editorials ON books.fk_editorial_id = editorials.id
        LEFT JOIN
        categories ON books.fk_category_id = categories.id;";

        $stmt = MysqlDb::connect()->prepare($sql);

        if ($stmt->execute()) {

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {

            print_r($stmt->errorInfo());
        }

        $stmt = null;
    }

    static public function newBook($value1, $value2, $value3, $value4, $value5, $value6, $value7)
    {
        $sql = "INSERT INTO books (title, fk_author_id, fk_editorial_id, fk_category_id, amount, publication_date, abbreviature)
                VALUES (:title, :fk_author_id, :fk_editorial_id, :fk_category_id, :amount, :publication_date, :abbreviature);";

        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(':title', $value1, PDO::PARAM_STR);
        $stmt->bindParam(':fk_author_id', $value2, PDO::PARAM_INT);
        $stmt->bindParam(':fk_editorial_id', $value3, PDO::PARAM_INT);
        $stmt->bindParam(':fk_category_id', $value4, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $value5, PDO::PARAM_INT);
        $stmt->bindParam(':publication_date', $value6, PDO::PARAM_INT);
        $stmt->bindParam(':abbreviature', $value7, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            print_r($stmt->errorInfo());
        }
    }

    static public function updateBook($value1, $value2, $value3, $value4, $value5, $value6, $value7, $value8)
    {
        $sql = "UPDATE books
                SET title = :title, fk_author_id = :fk_author_id, 
                    fk_editorial_id = :fk_editorial_id, fk_category_id = :fk_category_id,
                    amount = :amount, publication_date = :publication_date, 
                    abbreviature = :abbreviature
                    WHERE id = :id;";

        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(':id', $value1, PDO::PARAM_INT);
        $stmt->bindParam(':title', $value2, PDO::PARAM_STR);
        $stmt->bindParam(':fk_author_id', $value3, PDO::PARAM_INT);
        $stmt->bindParam(':fk_editorial_id', $value4, PDO::PARAM_INT);
        $stmt->bindParam(':fk_category_id', $value5, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $value6, PDO::PARAM_INT);
        $stmt->bindParam(':publication_date', $value7, PDO::PARAM_INT);
        $stmt->bindParam(':abbreviature', $value8, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            print_r($stmt->errorInfo());
        }

        $stmt = null;
    }

    static public function checkAbbreviatureDuplicates($abbreviature)
    {
        try {
            $query = "SELECT COUNT(*) FROM books WHERE abbreviature = ?;";
            $checkStatement = MysqlDb::connect()->prepare($query);
            $checkStatement->bindParam(1, $abbreviature, PDO::PARAM_STR);
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

    static public function checkDuplicatesForUpdate($abbreviature, $id)
    {
        $stmt = MysqlDb::connect()->prepare("SELECT COUNT(*) FROM books WHERE abbreviature = :abbreviature AND id != :id");
        $stmt->bindParam(":abbreviature", $abbreviature, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0 ? true : false;
    }
}
