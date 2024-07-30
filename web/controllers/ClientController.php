<?php

class ClientController
{
    static public function getAllClients()
    {
        return ClientModel::getAllClients();
    }

    static public function newClient()
    {
        if (
            !empty($_POST['lastNameClient']) && !empty($_POST['nameClient']) &&
            !empty($_POST['dniClient']) && !empty($_POST['emailClient']) &&
            !empty($_POST['addressClient'])
        ) {
            $last_name = ucwords(strtolower(trim($_POST['lastNameClient'])));
            $name = ucwords(strtolower(trim($_POST['nameClient'])));
            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $name) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $last_name)) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Los nombres y/o apellidos sólo pueden contener letras y espacios",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageClients";
                    });
                });
                </script>';
                return;
            }

            if (strlen($name) > 64 || strlen($last_name) > 64) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Nombres y/o apellidos demasiado largos.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageClients";
                    });
                });
                </script>';
                return;
            }

            $dni = trim($_POST['dniClient']);
            if (!preg_match('/^\d{7,8}$/', $dni)) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "DNI no válido.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageClients";
                    });
                });
                </script>';
                return;
            }

            $address = ucwords(strtolower(trim($_POST['addressClient'])));
            if (strlen($address) > 64) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Dirección demasiado larga.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageClients";
                    });
                });
                </script>';
                return;
            }

            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ0-9\s]+$/u", $address)) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "La dirección sólo puede contener letras, números y espacios.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageClients";
                    });
                });
                </script>';
                return;
            }

            $email = strtolower(trim($_POST['emailClient']));
            if ((filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Email no válido.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageClients";
                    });
                });
                </script>';
                return;
            }
            if (ClientModel::checkForDuplicates($dni, $email)) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Email o DNI ya registrados.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageClients";
                });
            });
            </script>';
                return;
            } else {
                $execute = ClientModel::newClient($last_name, $name, $dni, $address, $email);
                if ($execute) {
                    echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "El cliente se registró correctamente.",
                        showConfirmButton: false,
                        timer: 2000,
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageClients";
                    });
                });
                    </script>';
                } else {
                    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al registrar al cliente.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageClients";
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
                    window.location.href = "index.php?pages=manageClients";
                });
            });
            </script>';
        }
    }

    static public function quickNewClient()
    {
        if (!empty($_POST['lastNameClient']) && !empty($_POST['dniClient']) && !empty($_POST['emailClient'])) {
            $last_name = ucwords(strtolower(trim($_POST['lastNameClient'])));
            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $last_name)) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "El apellido sólo puede contener letras y espacios.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageLoans";
                });
            });
            </script>';
                return;
            }

            if (strlen($last_name) > 64) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Apellido demasiado largo.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageLoans";
                });
            });
            </script>';
                return;
            }

            $dni = trim($_POST['dniClient']);
            if (!preg_match('/^\d{7,8}$/', $dni)) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "DNI no válido.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageLoans";
                });
            });
            </script>';
                return;
            }

            $email = strtolower(trim($_POST['emailClient']));
            if ((filter_var($email, FILTER_VALIDATE_EMAIL)) === false) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Email no valido.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageLoans";
                });
            });
            </script>';
                return;
            }

            if (ClientModel::checkForDuplicates($dni, $email)) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Email o DNI ya registrados.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageLoans";
                });
            });
            </script>';
                return;
            } else {
                $execute = ClientModel::newClientQuick($last_name, $dni, $email);
                if ($execute) {
                    echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "El cliente se registró correctamente.",
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
                        text: "Hubo un problema al registrar al cliente.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageLoans";
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
                $("#quickCreateClientModal").modal("show");
            });
        });
        </script>';
        }
    }


    static public function updateClient()
    {
        $id = intval($_POST['id_client']);
        $last_name = ucwords(strtolower(trim($_POST['lastNameClient'])));
        $name = ucwords(strtolower(trim($_POST['nameClient'])));
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $name) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $last_name)) {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Los nombres y/o apellidos sólo pueden contener letras y espacios",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageClients";
                    });
                });
                </script>';
            return;
        }

        if (strlen($name) > 64 || strlen($last_name) > 64) {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Nombres y/o apellidos demasiado largos.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageClients";$("#editClientModal").modal("show");
                    });
                });
                </script>';
            return;
        }

        $address = ucwords(strtolower(trim($_POST['addressClient'])));
        if (strlen($address) > 64) {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Dirección demasiado larga.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageClients";
                    });
                });
                </script>';
            return;
        }

        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚ0-9\s]+$/u", $address)) {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "La dirección sólo puede contener letras, números y espacios.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageClients";
                    });
                });
                </script>';
            return;
        }

        $execute = ClientModel::updateClient($id, $last_name, $name, $address);
        if ($execute) {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "El cliente se actualizó correctamente.",
                        showConfirmButton: false,
                        timer: 2000,
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageClients";
                    });
                });
                    </script>';
        } else {
            echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al editar al cliente.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageClients";
                });
            });
            </script>';
        }
    }

    static public function enableClient()
    {
        if (isset($_GET['id_client'])) {
            $id = $_GET['id_client'];
            $execute = ClientModel::enableClient($id);

            if ($execute) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "El cliente se restauró.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageClients";
                });
            });
            </script>';
            } else {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudo restaurar al cliente.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageClients";
                });
            });
            </script>';
            }
        }
    }

    static public function disableClient()
    {
        if (isset($_GET['id_client'])) {
            $id = $_GET['id_client'];
            $execute = ClientModel::disableClient($id);

            if ($execute) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: "El cliente se dió de baja.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageClients";
                });
            });
            </script>';
            } else {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudo dar de baja.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageClients";
                });
            });
            </script>';
            }
        }
    }

    static public function allClientsSelect()
    {
        $clients = ClientModel::getAllClients();

        foreach ($clients as $client) {
            echo '<option value="' . htmlspecialchars($client['id_client']) . '">' . htmlspecialchars($client['last_name'] . " " . $client['name']) . '</option>';
        }
    }
}
