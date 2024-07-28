<?php

class BookController
{
    static public function getAllBooks()
    {
        return BookModel::getAllBooks();
    }

    static public function newBook()
    {
        if (
            !empty($_POST['title']) && !empty($_POST['abbreviature']) &&
            !empty($_POST['amount']) && !empty($_POST['publication_date']) &&
            !empty($_POST['fk_author_id']) && !empty($_POST['fk_editorial_id']) &&
            !empty($_POST['fk_category_id'])
        ) {

            $fk_author_id = intval($_POST['fk_author_id']);
            $fk_editorial_id = intval($_POST['fk_editorial_id']);
            $fk_category_id = intval($_POST['fk_category_id']);
            $title = ucwords(strtolower(trim($_POST['title'])));

            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ0-9\s]+$/u", $title)) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "El título sólo puede contener letras, números y espacios.",
                }).then((result) => {
                    $("#createBookModal").modal("show");
                });
            });
            </script>';
                return;
            }

            if (strlen($title) > 128) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "El título es demasiado largo.",
                }).then((result) => {
                    $("#createBookModal").modal("show");
                });
            });
            </script>';
                return;
            }

            $amount = intval($_POST['amount']);
            if ($amount > 999 || $amount < 1) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La cantidad debe ser entre 1 y 999.",
                }).then((result) => {
                    $("#createBookModal").modal("show");
                });
            });
            </script>';
                return;
            }

            $publication_date = intval($_POST['publication_date']);
            $currentYear = date("Y");
            if ($publication_date > $currentYear || $publication_date < 1000) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Año de publicación no válido.",
                }).then((result) => {
                    $("#createBookModal").modal("show");
                });
            });
            </script>';
                return;
            }

            $abbreviature = strtoupper(trim($_POST['abbreviature']));
            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ0-9]+$/u", $abbreviature)) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La abreviatura sólo puede contener letras y números.",
                }).then((result) => {
                    $("#createBookModal").modal("show");
                });
            });
            </script>';
                return;
            }

            if (strlen($abbreviature) > 4 || strlen($abbreviature) < 2) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La abreviatura debe tener entre 2 y 4 caracteres.",
                }).then((result) => {
                    $("#createBookModal").modal("show");
                });
            });
            </script>';
                return;
            }

            if (BookModel::checkAbbreviatureDuplicates($abbreviature)) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La abreviatura ya está registrada.",
                }).then((result) => {
                    $("#createBookModal").modal("show");
                });
            });
            </script>';
                return;
            } else {
                $execute = BookModel::newBook($title, $fk_author_id, $fk_editorial_id, $fk_category_id, $amount, $publication_date, $abbreviature);
                if ($execute) {
                    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "El libro se registró correctamente.",
                    showConfirmButton: false,
                    timer: 2000,
                }).then((result) => {
                    window.location.href = "index.php?pages=manageBooks";
                });
            });
                </script>';
                } else {
                    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al registrar el libro.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageBooks";
                });
            });
                </script>';
                }
            }
        } else {
            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Debe completar los campos.",
                }).then((result) => {
                    $("#createBookModal").modal("show");
                });
            });
                </script>';
        }
    }

    static public function updateBook()
    {
        if (
            !empty($_POST['id_book']) && !empty($_POST['title']) && !empty($_POST['abbreviature']) &&
            !empty($_POST['amount']) && !empty($_POST['publication_date']) &&
            !empty($_POST['fk_author_id']) && !empty($_POST['fk_editorial_id']) &&
            !empty($_POST['fk_category_id'])
        ) {

            $id = intval($_POST['id_book']);
            $fk_author_id = intval($_POST['fk_author_id']);
            $fk_editorial_id = intval($_POST['fk_editorial_id']);
            $fk_category_id = intval($_POST['fk_category_id']);
            $title = ucwords(strtolower(trim($_POST['title'])));

            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ0-9\s]+$/u", $title)) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "El título sólo puede contener letras, números y espacios.",
                }).then((result) => {
                    $("#editBookModal' . htmlspecialchars($_POST["id_book"]) . '").modal("show");
                });
            });
            </script>';
                return;
            }

            if (strlen($title) > 128) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "El título es demasiado largo.",
                }).then((result) => {
                    $("#editBookModal' . htmlspecialchars($_POST["id_book"]) . '").modal("show");
                });
            });
            </script>';
                return;
            }

            $amount = intval($_POST['amount']);
            if ($amount > 999 || $amount < 1) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La cantidad debe ser entre 1 y 999.",
                }).then((result) => {
                    $("#editBookModal' . htmlspecialchars($_POST["id_book"]) . '").modal("show");
                });
            });
            </script>';
                return;
            }

            $publication_date = intval($_POST['publication_date']);
            $currentYear = date("Y");
            if ($publication_date > $currentYear || $publication_date < 1000) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Año de publicación no válido.",
                }).then((result) => {
                    $("#editBookModal' . htmlspecialchars($_POST["id_book"]) . '").modal("show");
                });
            });
            </script>';
                return;
            }

            $abbreviature = strtoupper(trim($_POST['abbreviature']));
            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ0-9]+$/u", $abbreviature)) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La abreviatura sólo puede contener letras y números.",
                }).then((result) => {
                    $("#editBookModal' . htmlspecialchars($_POST["id_book"]) . '").modal("show");
                });
            });
            </script>';
                return;
            }

            if (strlen($abbreviature) > 4 || strlen($abbreviature) < 2) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La abreviatura debe tener entre 2 y 4 caracteres.",
                }).then((result) => {
                    $("#editBookModal' . htmlspecialchars($_POST["id_book"]) . '").modal("show");
                });
            });
            </script>';
                return;
            }

            if (BookModel::checkDuplicatesForUpdate($abbreviature, $id)) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La abreviatura ya está registrada.",
                }).then((result) => {
                    $("#editBookModal' . htmlspecialchars($_POST["id_book"]) . '").modal("show");
                });
            });
            </script>';
                return;
            } else {
                $execute = BookModel::updateBook($id, $title, $fk_author_id, $fk_editorial_id, $fk_category_id, $amount, $publication_date, $abbreviature);
                if ($execute) {
                    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "El libro se registró correctamente.",
                    showConfirmButton: false,
                    timer: 2000,
                }).then((result) => {
                    window.location.href = "index.php?pages=manageBooks";
                });
            });
                </script>';
                } else {
                    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al registrar el libro.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageBooks";
                });
            });
                </script>';
                }
            }
        } else {
            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Debe completar los campos.",
                }).then((result) => {
                    $("#editBookModal' . htmlspecialchars($_POST["id_book"]) . '").modal("show");
                });
            });
                </script>';
        }
    }


    public function getCurrentYear()
    {
        return date("Y");
    }
}
