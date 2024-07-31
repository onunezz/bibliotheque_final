<?php $data = UserController::sessionDataUser($_SESSION['id_user']) ?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <div class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-book-open"></i>
        </div>
        <div class="sidebar-brand-text mx-3">bblthq</div>
    </div>

    <?php if ($data['change_password'] != 0) : ?>
        <hr class="sidebar-divider mb-0">

        <li class="nav-item margin-nav-item">
            <a class="nav-link" href="index.php?pages=home">
                <i class="fas fa-fw fa-home"></i>
                <span class="font-weight-bold">Inicio</span></a>
        </li>

        <hr class="sidebar-divider mb-0">
    <?php endif; ?>

    <?php
    if ($_SESSION['fk_role_id'] == 1) {
        include_once "sidebarAdmin.php";
    }
    if ($_SESSION['fk_role_id'] == 2) {
        include_once "sidebarLibrarian.php";
    }
    ?>
</ul>