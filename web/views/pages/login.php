<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bibliotheque | Iniciar sesión</title>
    <link href="public/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="public/css/sb-admin-2.min.css">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center mb-3 text-lg">
                                <div class="sidebar-brand d-flex align-items-center justify-content-center">
                                    <div class="sidebar-brand-icon rotate-n-15">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <div class="sidebar-brand-text mx-3">bblthq</div>
                                </div>
                            </div>
                            <form class="user" method="POST">
                                <div class="form-group">
                                    <input type="email" id="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" id="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Contraseña" name="password" required>
                                </div>
                                <hr>
                                <button class="btn btn-primary btn-user btn-block" type="submit" name="send">
                                    Ingresar
                                </button>
                                <?php
                                if (isset($_POST['send'])) {
                                    $controller = new UserController();
                                    $controller->control_login();
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="public/plugins/jquery/jquery.min.js"></script>
    <script src="public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/js/sb-admin-2.min.js"></script>
</body>

</html>