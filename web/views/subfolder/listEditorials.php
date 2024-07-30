<?php $editorials = EditorialController::getAllEditorials(); ?>
<h1 class="h3 mb-4 text-gray-800">Gestión de editoriales</h1>
<div class="d-flex justify-content-center">
    <div class="card shadow mb-4 col-sm-9 col-xl-10">
        <div class="card-header py-3 bg-white">
            <button class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#createEditorialModal" title="Crear editorial">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Nueva editorial</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="ID: activate to sort column ascending" style="width: 55px;">ID</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Editorial: activate to sort column descending" aria-sort="ascending" style="width: 230px;">Editorial</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Estado: activate to sort column ascending" style="width: 105px;">Estado</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 45px;">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th rowspan="1" colspan="1">ID</th>
                            <th rowspan="1" colspan="1">Editorial</th>
                            <th rowspan="1" colspan="1">Estado</th>
                            <th rowspan="1" colspan="1">Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($editorials as $editorial) : ?>
                            <tr>
                                <td><?php echo $editorial['id_editorial'] ?></td>
                                <td><?php echo $editorial['name'] ?></td>
                                <td class="text-center"><?php echo $editorial['state'] == 1 ? '<span class="badge badge-pill badge-success">Activa</span>' : '<span class="badge badge-pill badge-danger">Inactiva</span>'; ?></td>
                                <td class="text-center">
                                    <?php if ($editorial['state'] == 1) : ?>
                                        <a href="index.php?pages=manageEditorials&action=disableEditorial&id_editorial=<?php echo $editorial['id_editorial'] ?>" class="btn btn-success" title="Deshabilitar editorial"><i class="fas fa-toggle-on"></i></a>
                                    <?php else : ?>
                                        <a href="index.php?pages=manageEditorials&action=enableEditorial&id_editorial=<?php echo $editorial['id_editorial'] ?>" class="btn btn-danger" title="Habilitar editorial"><i class="fas fa-toggle-off"></i></a>
                                    <?php endif; ?>
                                    <a href="#editEditorialModal<?php echo $editorial['id_editorial']; ?>" class="btn btn-primary edit-user" data-toggle="modal">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['action'])) {
        if ($_GET['action'] == "disableEditorial") {
            $controller = new EditorialController();
            $controller->disableEditorial();
        }

        if ($_GET['action'] == "enableEditorial") {
            $controller = new EditorialController();
            $controller->enableEditorial();
        }
    } ?>

    <div class="modal fade" id="createEditorialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Nueva editorial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createEditorialForm" method="POST">
                        <div class="form-group">
                            <label for="nameEditorial">Nombre </label>
                            <input type="text" class="form-control" id="nameEditorial" name="nameEditorial" placeholder="Ingrese el nombre de la editorial" required>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" form="createEditorialForm" class="btn btn-primary" name="loadEditorial">Enviar</button>
                </div>
                <?php
                if (isset($_POST['loadEditorial'])) {
                    $controller = new EditorialController();
                    $controller->newEditorial();
                }
                ?>
            </div>
        </div>
    </div>

    <?php foreach ($editorials as $editorial) : ?>

        <div class="modal fade" id="editEditorialModal<?php echo $editorial['id_editorial']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Cambiar nombre de editorial</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editEditorialForm<?php echo $editorial['id_editorial']; ?>" method="POST" action="index.php?pages=manageEditorials">
                            <input type="hidden" name="idEditorial" value="<?php echo $editorial['id_editorial']; ?>">
                            <div class="form-group">
                                <label for="nameEditorial">Nombre</label>
                                <input type="text" class="form-control" id="nameEditorial" name="nameEditorial" value="<?php echo $editorial['name']; ?>" placeholder="Ingrese el nombre de la editorial" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" form="editEditorialForm<?php echo $editorial['id_editorial']; ?>" class="btn btn-primary" name="changeEditorial">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach ?>

    <?php
    if (isset($_POST['changeEditorial'])) {
        $controller = new EditorialController();
        $controller->updateEditorial();
    }
