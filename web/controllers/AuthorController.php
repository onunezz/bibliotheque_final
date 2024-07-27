<?php

class AuthorController
{
    static public function getAllAuthors()
    {
        return AuthorModel::getAllAuthors();
    }

    static public function newAuthor()
    {
        if ((!empty($_POST['nameAuthor'])) && (!empty($_POST['lastNameAuthor'])) &&
            !empty($_POST['fk_nationality_id'])
        ) {
            $name = ucwords(strtolower(trim($_POST['nameAuthor'])));
            $last_name = ucwords(strtolower(trim($_POST['lastNameAuthor'])));
            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/u", $name) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/u", $last_name)) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Los nombres y/o apellidos sólo pueden contener letras y espacios",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageAuthors";
                    });
                });
                </script>';
            }

            if (strlen($name) > 128 || strlen($last_name) > 128) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Nombres y/o apellidos demasiado largos.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageAuthors";
                    });
                });
                </script>';
            }

            $nationality = $_POST['fk_nationality_id'];

            if (AuthorModel::checkDuplicates($name, $last_name)) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "El autor ya está registrado.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageAuthors";
                    });
                });
                </script>';
                return;
            } else {
                $execute = AuthorModel::newAuthor($name, $last_name, $nationality);
                if ($execute) {
                    echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "El autor se registró correctamente.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageAuthors";
                    });
                });
                    </script>';
                } else {
                    echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Hubo un problema al registrar al autor.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageAuthors";
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
                        window.location.href = "index.php?pages=manageAuthors";
                    });
                });
                    </script>';
        }
    }

    static public function updateAuthor()
    {
        if (!empty($_POST['id_author']) && !empty($_POST['nameAuthor']) && !empty($_POST['lastNameAuthor']) && !empty($_POST['fk_nationality_id'])) {
            $id = intval($_POST['id_author']);
            $name = ucwords(strtolower(trim($_POST['nameAuthor'])));
            $last_name = ucwords(strtolower(trim($_POST['lastNameAuthor'])));
            $nationality = intval($_POST['fk_nationality_id']);

            // Validación de longitud
            if (strlen($name) > 128 || strlen($last_name) > 128) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Nombres y/o apellidos demasiado largos.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageAuthors";
                });
            });
            </script>';
                return;
            }

            // Validación de caracteres
            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/u", $name) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/u", $last_name)) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Los nombres y/o apellidos sólo pueden contener letras y espacios.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageAuthors";
                });
            });
            </script>';
                return;
            }

            // Actualización en la base de datos
            $execute = AuthorModel::updateAuthor($id, $name, $last_name, $nationality);
            if ($execute) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "El autor se actualizó correctamente.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageAuthors";
                });
            });
            </script>';
            } else {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al actualizar el autor.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageAuthors";
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
                text: "Debe completar todos los campos.",
            }).then((result) => {
                window.location.href = "index.php?pages=manageAuthors";
            });
        });
        </script>';
        }
    }
}
