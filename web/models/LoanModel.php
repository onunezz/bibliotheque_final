<?php

class LoanModel
{
    static public function getAllLoans()
    {
        $sql = "SELECT 
        loans.id AS id_loan,
        loans.fk_client_id AS fk_client_id,
        loans.fk_book_id AS fk_book_id,
        loans.loan_date AS loan_date,
        loans.return_date AS return_date,
        loans.amount AS amount,
        loans.state AS state,
        clients.id AS id_client,
        clients.last_name AS last_name_client,
        clients.name AS name_client, 
        clients.state AS state_client,
        books.id AS id_book,
        books.title AS title,
        books.amount AS amount_book,
        books.abbreviature AS abbreviature
        FROM
        loans
        LEFT JOIN
        clients ON loans.fk_client_id = clients.id
        LEFT JOIN 
        books ON loans.fk_book_id = books.id;";

        $stmt = MysqlDb::connect()->prepare($sql);

        if ($stmt->execute()) {

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {

            print_r($stmt->errorInfo());
        }

        $stmt = null;
    }

    static public function newLoan($fk_client_id, $fk_book_id, $amount, $loan_date, $return_date)
    {
        $sql = "INSERT INTO loans (fk_client_id, fk_book_id, amount, loan_date, return_date)
                VALUES (:fk_client_id, :fk_book_id, :amount, :loan_date, :return_date);";

        $stmt = MysqlDb::connect()->prepare($sql);
        $stmt->bindParam(':fk_client_id', $fk_client_id, PDO::PARAM_INT);
        $stmt->bindParam(':fk_book_id', $fk_book_id, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
        $stmt->bindParam(':loan_date', $loan_date, PDO::PARAM_STR);
        $stmt->bindParam(':return_date', $return_date, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt;
        } else {
            print_r($stmt->errorInfo());
        }
    }

    public static function getLoanDetails($id_loan)
    {
        $db = MysqlDb::connect();
        $stmt = $db->prepare("SELECT fk_book_id, amount FROM loans WHERE id = :id_loan");
        $stmt->bindParam(":id_loan", $id_loan, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function returnCheck($id)
    {
        $sql = "UPDATE loans SET state = 2 WHERE id = ?;";
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
