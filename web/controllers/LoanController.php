<?php

class LoanController
{
    static public function getAllLoans()
    {
        return LoanModel::getAllLoans();
    }

    static public function newLoan()
    {
        if (
            !empty($_POST['fk_client_id']) && !empty($_POST['fk_book_id']) &&
            !empty($_POST['amount']) && !empty($_POST['loan_date']) &&
            !empty($_POST['return_date'])
        ) {
            $fk_client_id = intval($_POST['fk_client_id']);
            $fk_book_id = intval($_POST['fk_book_id']);
            $amount = intval($_POST['amount']);
            $loan_date = $_POST['loan_date'];
            $return_date = $_POST['return_date'];

            $available_amount = BookModel::getBookQuantity($fk_book_id);

            if ($amount > $available_amount) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "La cantidad solicitada de libros excede la cantidad disponible.",
                    });
                });
            </script>';
                return;
            }

            if ($loan_date > $return_date) {
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "La fecha de préstamo no puede ser posterior a la fecha de retorno.",
                        });
                    });
                </script>';
                return;
            }

            $current_date = date('Y-m-d');
            if ($loan_date < $current_date) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "La fecha de préstamo no puede ser anterior a la fecha actual.",
                    });
                });
            </script>';
                return;
            }

            if ($return_date < $loan_date) {
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "La fecha de retorno no puede ser anterior a la fecha de préstamo.",
                        });
                    });
                </script>';
                return;
            }

            $execute = LoanModel::newLoan($fk_client_id, $fk_book_id, $amount, $loan_date, $return_date);
            if ($execute) {
                BookModel::updateBookQuantity($fk_book_id, $available_amount - $amount);
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "El préstamo se registró correctamente.",
                    showConfirmButton: false,
                    timer: 2000,
                }).then((result) => {
                    window.location.href = "index.php?pages=manageLoans";
                });
            });
                </script>';
            } else {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al registrar el préstamo.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageLoans";
                });
            });
                </script>';
            }
        } else {
            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Debe completar los campos.",
                }).then((result) => {
                    $("#createLoanModal").modal("show");
                });
            });
                </script>';
        }
    }

    static public function returnCheck()
    {
        if (isset($_GET['id_loan'])) {
            $id_loan = intval($_GET['id_loan']);

            $loan_details = LoanModel::getLoanDetails($id_loan);
            if (!$loan_details) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No se encontraron detalles del préstamo.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageLoans";
                    });
                });
            </script>';
                return;
            }

            $fk_book_id = intval($loan_details['fk_book_id']);
            $amount = intval($loan_details['amount']);

            $execute = LoanModel::returnCheck($id_loan);
            if ($execute) {
                $available_amount = BookModel::getBookQuantity($fk_book_id);

                BookModel::updateBookQuantity($fk_book_id, $available_amount + $amount);

                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "Préstamo concluído.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageLoans";
                    });
                });
            </script>';
            } else {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No se pudo concluir el préstamo.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageLoans";
                    });
                });
            </script>';
            }
        }
    }

    static public function getLoanDetails($id_loan)
    {
        return LoanModel::fetchLoanDetails($id_loan);
    }
}
