<?php
class UserController
{
    public function control_login()
    {
        if ((!empty($_POST['email'])) && !empty($_POST['password'])) {
            $mail = $_POST['email'];
            $password = $_POST['password'];

            $verificar = UserModel::login($mail, $password);
            if ($verificar != false) {
                $mail_user = $verificar['email'];
                $id_user = $verificar['id'];
                $rol = $verificar['fk_role_id'];
                $state = $verificar['state'];

                if ($state == 1) {
                    $_SESSION['state'] = $state;
                    $_SESSION['email'] = $mail_user;
                    $_SESSION['fk_role_id'] = $rol;
                    $_SESSION['id_user'] = $id_user;

                    echo '<script>
                    if ( window.history.replaceState ) {
                        window.history.replaceState(null, null, window.location.href);
                    }
        
                    window.location="../index.php?pages=home";
                    </script>';
                }
            } else {
                echo '<script>
                    if ( window.history.replaceState ) {
                        window.history.replaceState(null, null, window.location.href);
                    }
                    </script>
                    <div class="alert alert-danger mt-2">Usuario o Contraseña incorrecta</div>';
            }
        } else {
            echo '<script>
			if ( window.history.replaceState ) {
				window.history.replaceState(null, null, window.location.href);
			}
			alert("Debes completar los campos");
			</script>';
        }
    }

    static public function sessionDataUser($id)
    {
        $dataUser = UserModel::dataUser($id);
        return $dataUser;
    }

    static public function getAllUsers()
    {
        return UserModel::getAllUsers();
    }

    static public function newUser()
    {
        if (
            !empty($_POST['lastNameUser']) && !empty($_POST['nameUser']) &&
            !empty($_POST['dniUser']) && !empty($_POST['fk_role_id']) && !empty($_POST['emailUser'])
        ) {
            $lastNameUser = ucwords(strtolower(trim($_POST['lastNameUser'])));
            $nameUser = ucwords(strtolower(trim($_POST['nameUser'])));
            $fk_role_id = intval($_POST['fk_role_id']);
            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $nameUser) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $lastNameUser)) {
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Los nombres y/o apellidos sólo pueden contener letras y espacios",
                        }).then((result) => {
                            window.location.href = "index.php?pages=manageUsers";
                        });
                    });
                    </script>';
                return;
            }

            if (strlen($nameUser) > 64 || strlen($lastNameUser) > 64) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Nombres y/o apellidos demasiado largos.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageUsers";
                    });
                });
                </script>';
                return;
            }

            $dniUser = intval(trim($_POST['dniUser']));
            if (!preg_match('/^\d{7,8}$/', $dniUser)) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "DNI no válido.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageUsers";
                    });
                });
                </script>';
                return;
            }


            $emailUser = strtolower(trim($_POST['emailUser']));
            if ((filter_var($emailUser, FILTER_VALIDATE_EMAIL)) === false) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Email no válido.",
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageUsers";
                    });
                });
                </script>';
                return;
            }

            if (UserModel::checkForDuplicates($dniUser, $emailUser)) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Email o DNI ya registrados.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageUsers";
                });
            });
            </script>';
                return;
            } else {
                $execute = UserModel::newUser($lastNameUser, $nameUser, $dniUser, $fk_role_id, $emailUser);
                if ($execute) {
                    echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "El usuario se registró correctamente.",
                        showConfirmButton: false,
                        timer: 2000,
                    }).then((result) => {
                        window.location.href = "index.php?pages=manageUsers";
                    });
                });
                    </script>';
                } else {
                    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al registrar al usuario.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageUsers";
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
                    window.location.href = "index.php?pages=manageUsers";
                });
            });
            </script>';
        }
    }
}
