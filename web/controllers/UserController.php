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
}
