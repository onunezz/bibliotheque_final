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
                $changed = $verificar['change_password'];

                if ($state == 1) {
                    $_SESSION['state'] = $state;
                    $_SESSION['email'] = $mail_user;
                    $_SESSION['fk_role_id'] = $rol;
                    $_SESSION['id_user'] = $id_user;
                    $_SESSION['change_password'] = $changed;

                    if ($changed == 0) {
                        echo '<script>
                    if ( window.history.replaceState ) {
                        window.history.replaceState(null, null, window.location.href);
                    }

                    window.location="../index.php?pages=changePasswordStart"; //AGREGAR VISTA CHANGEDPASSWORD
                    </script>';
                    }

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
            $generatePassword = self::generateRandomPassword(14);
            $hashedPassword = password_hash($generatePassword, PASSWORD_DEFAULT);

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
                $execute = UserModel::newUser($lastNameUser, $nameUser, $dniUser, $fk_role_id, $emailUser, $hashedPassword);
                if ($execute) {
                    MailerController::sendNewUser($generatePassword, $emailUser, $nameUser, $lastNameUser);
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

    static public function updateUser()
    {
        $id = intval($_POST['id_user']);
        $last_name = ucwords(strtolower(trim($_POST['lastNameUser'])));
        $name = ucwords(strtolower(trim($_POST['nameUser'])));
        $fk_role_id = intval(trim($_POST['fk_role_id']));
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $name) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $last_name)) {
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

        if (strlen($name) > 64 || strlen($last_name) > 64) {
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

        $execute = UserModel::updateUser($id, $last_name, $name, $fk_role_id);
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
                    text: "Hubo un problema al editar al cliente.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageUsers";
                });
            });
            </script>';
        }
    }

    static public function generateRandomPassword($length)
    {
        $character = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
        $password = "";
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($character) - 1);
            $password .= $character[$index];
        }

        return $password;
    }

    static public function changePasswordStart()
    {
        if (!empty($_POST['newPassword']) && !empty($_POST['confirmPassword'])) {
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            if ($newPassword !== $confirmPassword) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Las contraseñas no coinciden.",
                }).then((result) => {
                    window.location.href = "index.php?pages=changePasswordStart";
                });
            });
            </script>';
                return;
            }

            if (strlen($newPassword) < 8) {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La contraseña debe ser de más de 8 caracteres.",
                }).then((result) => {
                    window.location.href = "index.php?pages=changePasswordStart";
                });
            });
            </script>';
                return;
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $result = UserModel::changePasswordStart($_SESSION['id_user'], $hashedPassword);

            if ($result) {
                $_SESSION['change_password'] = 1;
                echo '<script>
                            if ( window.history.replaceState ) {
                                window.history.replaceState(null, null, window.location.href);
                            }
                            window.location="../index.php?pages=logout";
                          </script>';
            } else {
                echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Ocurrió un error. Intente más tarde",
                }).then((result) => {
                    window.location.href = "../index.php?pages=logout";
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
                    window.location.href = "../index.php?pages=changePasswordStart";
                });
            });
            </script>';
        }
    }

    static public function sendNewAleatoryPasswordEmail()
    {
        if (isset($_GET['id_user'])) {
            $id = $_GET['id_user'];
            $changedPassword = UserModel::updateChangedPassword($id);

            if ($changedPassword) {
                $dataUser = UserModel::dataUser($id);
                $emailData = $dataUser['email'];
                $generatePassword = self::generateRandomPassword(14);
                $hashedPassword = password_hash($generatePassword, PASSWORD_DEFAULT);

                $updateNewPassword = UserModel::updateNewPassword($hashedPassword, $id);
                if ($updateNewPassword) {
                    $mailSend = MailerController::generateNewPasswordviaEmail($emailData, $generatePassword);
                    if ($mailSend) {
                        echo '<script>
                                    if (window.history.replaceState) {
                                        window.history.replaceState(null, null, window.location.href);
                                    }
                                    window.location="../index.php?pages=manageUser&message=correcto";
                                    </script>';
                    } else {
                        echo '<script>
                                    if (window.history.replaceState) {
                                        window.history.replaceState(null, null, window.location.href);
                                    }
                                    alert("No se pudo enviar el email.");
                                    </script>';
                    }
                } else {
                    echo '<script>
                                if (window.history.replaceState) {
                                    window.history.replaceState(null, null, window.location.href);
                                }
                                alert("No se pudo actualizar la contraseña.");
                                </script>';
                }
            }
        }
    }

    static public function disableAccountUser()
    {
        if (isset($_GET['id_user'])) {
            $id = $_GET['id_user'];
            $execute = UserModel::disableUser($id);

            if ($execute) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "El usuario se deshabilitó correctamente.",
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
                    text: "No se pudo deshabilitar al usuario.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageUsers";
                });
            });
            </script>';
            }
        }
    }

    static public function enableAccountUser()
    {
        if (isset($_GET['id_user'])) {
            $id = $_GET['id_user'];
            $execute = UserModel::activateUser($id);

            if ($execute) {
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "success",
                        title: "Éxito",
                        text: "El usuario se habilitó correctamente.",
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
                    text: "No se pudo habilitar al usuario.",
                }).then((result) => {
                    window.location.href = "index.php?pages=manageUsers";
                });
            });
            </script>';
            }
        }
    }
}
