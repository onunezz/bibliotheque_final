<?php $users = UserController::getAllUsers(); ?>
<h1 class="h3 mb-4 text-gray-800">Gestión de usuarios</h1>
<div class="d-flex justify-content-center">
    <div class="card shadow mb-4 col-sm-10 col-xl-11">
        <div class="card-header py-3 bg-white">
            <button class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#createUserModal" title="Crear usuario">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Nuevo usuario</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="ID: activate to sort column ascending" style="width: 55px;">ID</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column descending" aria-sort="ascending" style="width: 230px;">Nombre</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 105px;">Email</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Rol: activate to sort column ascending" style="width: 105px;">Rol</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Estado: activate to sort column ascending" style="width: 105px;">Estado</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 45px;">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th rowspan="1" colspan="1">ID</th>
                            <th rowspan="1" colspan="1">Nombre</th>
                            <th rowspan="1" colspan="1">Email</th>
                            <th rowspan="1" colspan="1">Rol</th>
                            <th rowspan="1" colspan="1">Estado</th>
                            <th rowspan="1" colspan="1">Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id_user']); ?></td>
                                <td><?php echo htmlspecialchars($user['last_name']) . " " . htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td class="text-center"><?php echo $user['fk_role_id'] == 1 ? '<span class="badge badge-pill badge-success">Administrador/a</span>' : '<span class="badge badge-pill badge-primary">Bibliotecario/a</span>'; ?></td>
                                <td class="text-center"><?php echo $user['state'] == 1 ? '<span class="badge badge-pill badge-success">Activo</span>' : '<span class="badge badge-pill badge-danger">Inactivo</span>'; ?></td>
                                <td class="text-center">
                                    <?php if ($user['state'] == 1) : ?>
                                        <a href="index.php?pages=manageUsers&action=disableUser&id_user=<?php echo $user['id_user'] ?>" class="btn btn-success" title="Deshabilitar usuario"><i class="fas fa-toggle-on"></i></a>
                                    <?php else : ?>
                                        <a href="index.php?pages=manageUsers&action=enableUser&id_user=<?php echo $user['id_user'] ?>" class="btn btn-danger" title="Habilitar usuario"><i class="fas fa-toggle-off"></i></a>
                                    <?php endif; ?>
                                    <a href="#editUserModal<?php echo htmlspecialchars($user['id_user']); ?>" class="btn btn-primary edit-user" data-toggle="modal">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Nuevo usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm" method="POST">
                        <div class="row">
                            <div class="form-group w-75 col-md-6">
                                <label for="lastNameUser">Apellido/s</label>
                                <input type="text" class="form-control" id="lastNameUser" name="lastNameUser" required>
                            </div>
                            <div class="form-group w-75 col-md-6">
                                <label for="nameUser">Nombre/s</label>
                                <input type="text" class="form-control" id="nameUser" name="nameUser" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group w-75 col-md-6">
                                <label for="dniUser">DNI</label>
                                <input type="number" class="form-control" id="dniUser" name="dniUser" required>
                            </div>
                            <div class="form-group w-75 col-md-6">
                                <label for="fk_role_id">Rol</label>
                                <select class="form-control" name="fk_role_id" id="fk_role_id" required>
                                    <option value="" disabled selected>Seleccione rol</option>
                                    <?php (new RoleController())->allRolesSelect(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group w-75 col-md-12">
                                <label for="emailUser">Email</label>
                                <input type="email" class="form-control" id="emailUser" name="emailUser" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" form="createUserForm" class="btn btn-primary" name="loadUser">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['loadUser'])) {
        $controller = new UserController();
        $controller->newUser();
    }
    ?>