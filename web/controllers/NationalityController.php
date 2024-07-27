<?php

class NationalityController
{
    static public function getAllNationalities()
    {
        return NationalityModel::getAllNationalities();
    }

    static public function newNationality()
    {
        if (!empty($_POST['nationalityAuthor'])) {
            $nationality = ucwords(strtolower(trim($_POST['nationalityAuthor'])));
            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/u", $nationality)) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "La nacionalidad sólo puede contener letras y espacios",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageAuthors";
                    });
                });
                </script>';
            }

            if (strlen($nationality) > 45) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Nombre de nación demasiado largo.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageAuthors";
                    });
                });
                </script>';
            }

            if (NationalityModel::checkNationalityDuplicates($nationality)) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "La nacionalidad ya está registrada.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageAuthors";
                    });
                });
                </script>';
                return;
            } else {
                $execute = NationalityModel::newNationality($nationality);
                if ($execute) {
                    echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "La nacionalidad se registró correctamente.",
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
                        text: "Hubo un problema al registrar la nacionalidad.",
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

    public function nationalitiesSelect($selectedNationality)
    {
        $nationalities = NationalityModel::getAllNationalities();

        foreach ($nationalities as $value) {
            $selected = $value['id_nationality'] == $selectedNationality ? 'selected' : '';
            echo '<option value="' . $value['id_nationality'] . '" ' . $selected . '>' . $value['name'] . '</option>';
        }
    }

    public function allNationalitiesSelect()
    {
        $nationalities = NationalityModel::getAllNationalities();

        foreach ($nationalities as $key => $value) {
            echo '<option value="' . $value['id_nationality'] . '">' . $value['country'] . '</option>';
        }
    }
}
