<?php
class EditorialController
{
    static public function getAllEditorials()
    {
        return EditorialModel::getAllEditorials();
    }

    static public function newEditorial()
    {
        if (!empty($_POST['nameEditorial'])) {
            $name = ucwords(strtolower((trim($_POST['nameEditorial']))));

            if (strlen($name) > 50) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Nombre demasiado largo.",
                    }).then((result) => {
                        $("#createEditorialModal").modal("show");
                    });
                });
                </script>';
                return;
            }

            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ0-9\s]+$/", $name)) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "El nombre sólo puede contener letras, números y espacios.",
                    }).then((result) => {
                        $("#createEditorialModal").modal("show");
                    });
                });
                    </script>';
                return;
            } // Sólo letras, número y espacios

            $checkCountName = EditorialModel::checkDuplicates($name);
            if ($checkCountName !== false) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "El nombre de la editorial ya está registrado.",
                    }).then((result) => {
                        $("#createEditorialModal").modal("show");
                    });
                });
                    </script>';
            } else { //El nombre de la editorial ya está registrado.
                $execute = EditorialModel::newEditorial($name);
                if ($execute) {
                    echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "La editorial se registró correctamente.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageEditorials";
                    });
                });
                    </script>';
                } else {
                    echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Hubo un problema al registrar la editorial.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageEditorials";
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
                        $("#createEditorialModal").modal("show");
                    });
                });
                    </script>';
        }
    }

    static public function updateEditorial()
    {
        if (!empty($_POST['idEditorial']) && !empty($_POST['nameEditorial'])) {
            $id = intval($_POST['idEditorial']);
            $name = ucwords(strtolower(trim($_POST['nameEditorial'])));

            // Validación de longitud
            if (strlen($name) > 50) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Nombre demasiado largo.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageEditorials";
                });
            });
            </script>';
                return;
            }

            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ0-9\s]+$/", $name)) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "El nombre sólo puede contener letras, números y espacios.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageEditorials";
                });
            });
            </script>';
                return;
            }

            $checkCountName = EditorialModel::checkDuplicatesForUpdate($name, $id);
            if ($checkCountName !== false) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "El nombre de la editorial ya está registrado.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageEditorials";
                });
            });
            </script>';
                return;
            }

            $execute = EditorialModel::updateEditorial($id, $name);
            if ($execute) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "La editorial se actualizó correctamente.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageEditorials";
                });
            });
            </script>';
            } else {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al actualizar la editorial.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageEditorials";
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
                window.location.href = "index.php?pages=manageEditorials";
            });
        });
        </script>';
        }
    }

    static public function enableEditorial()
    {
        if (isset($_GET['id_editorial'])) {
            $id = $_GET['id_editorial'];
            $execute = EditorialModel::enableEditorial($id);

            if ($execute) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "La editorial se activó correctamente.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageEditorials";
                });
            });
            </script>';
            } else {
                echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "No se pudo activar.",
            }).then((result) => {
                window.location.href = "index.php?pages=manageEditorials";
            });
        });
        </script>';
            }
        }
    }

    static public function disableEditorial()
    {
        if (isset($_GET['id_editorial'])) {
            $id = $_GET['id_editorial'];
            $execute = EditorialModel::disableEditorial($id);

            if ($execute) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "La editorial se desactivó correctamente.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageEditorials";
                });
            });
            </script>';
            } else {
                echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "No se pudo desactivar.",
            }).then((result) => {
                window.location.href = "index.php?pages=manageEditorials";
            });
        });
        </script>';
            }
        }
    }

    public function allEditorialsSelect()
    {
        $editorials = EditorialModel::getAllEditorials();

        foreach ($editorials as $editorial) {
            echo '<option value="' . htmlspecialchars($editorial['id_editorial']) . '">' . htmlspecialchars($editorial['name']) . '</option>';
        }
    }

    public function editorialsSelect($selectedEditorial)
    {
        $editorials = EditorialModel::getAllEditorials();

        foreach ($editorials as $editorial) {
            $selected = ($editorial['id_editorial'] == $selectedEditorial) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($editorial['id_editorial']) . '" ' . $selected . '>' . htmlspecialchars($editorial['name']) . '</option>';
        }
    }
}
