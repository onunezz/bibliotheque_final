<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item no-arrow mx-1">
            <div class="nav-link" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small biggerText">
                    <?php $data = UserController::sessionDataUser($_SESSION['id_user']) ?>
                    <?php echo $data['fk_role_id'] == 1 ? '<span class="badge badge-pill badge-success">Administrador</span>' : '<span class="badge badge-pill badge-danger">Bibliotecario</span>'; ?>
                </span>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>


        <li class="nav-item no-arrow mx-1">
            <div class="nav-link" id="userDropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small biggerText">
                    <?php $data = UserController::sessionDataUser($_SESSION['id_user']) ?>
                    <?php echo $data['name_user'] . " " . $data['last_name_user'] ?>
                </span>
                <i class="fas fa-user"></i>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <a class="btn btn-danger my-3" id="logout-button" role="button" title="Cerrar Sesión">
            <i class="text-white text-center fas fa-power-off"></i>
        </a>

    </ul>

</nav>