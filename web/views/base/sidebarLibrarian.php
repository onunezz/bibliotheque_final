<?php $data = UserController::sessionDataUser($_SESSION['id_user']) ?>
<?php if ($data['change_password'] != 0) : ?>
    <li class="nav-item margin-nav-item">
        <a class="nav-link" href="index.php?pages=manageClients">
            <i class=" fas fa-fw fa-user"></i>
            <span class="font-weight-bold">Clientes</span></a>
    </li>

    <li class="nav-item margin-nav-item">
        <a class="nav-link" href="index.php?pages=manageLoans">
            <i class="fas fa-fw fa-file-export"></i>
            <span class="font-weight-bold">Préstamos</span></a>
    </li>

    <li class="nav-item margin-nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-book"></i>
            <span class="font-weight-bold">Libros</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="index.php?pages=manageEditorials">Editoriales</a>
                <a class="collapse-item" href="index.php?pages=manageAuthors">Autores</a>
                <a class="collapse-item" href="index.php?pages=manageBooks">Gestión de libros</a>
            </div>
        </div>
    </li>



    <hr class="sidebar-divider mb-0">

    <li class="nav-item margin-nav-item">
        <a class="nav-link" href="index.php?pages=manageUsers">
            <i class="fas fa-fw fa-users"></i>
            <span class="font-weight-bold">Usuarios</span></a>
    </li>

    <li class="nav-item margin-nav-item">
        <a class="nav-link" href="index.php?pages=home&action=dailyReport" target="_blank">
            <i class="fas fa-fw fa-download"></i>
            <span class="font-weight-bold">Reporte</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    <?php
    if (isset($_GET['action']) && $_GET['action'] == "dailyReport") {
        LoanController::generateDailyReport();
    }
    ?>

<? endif; ?>