<?php $authors = AuthorController::getAllAuthors(); ?>
<h1 class="h3 mb-4 text-gray-800">Gestión de autores</h1>
<div class="d-flex justify-content-center">
    <div class="card shadow mb-4 col-sm-9 col-xl-10">
        <div class="card-header py-3 bg-white">
            <button class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#createAuthorModal" title="Crear autor">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Nuevo autor</span>
            </button>
            <button class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#createNationalityModal" title="Crear nacionalidad">
                <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                </span>
                <span class="text">Nueva nacionalidad </span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="ID: activate to sort column ascending" style="width: 55px;">ID</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column descending" aria-sort="ascending" style="width: 230px;">Nombre</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Nacionalidad: activate to sort column ascending" style="width: 105px;">Nacionalidad</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 45px;">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th rowspan="1" colspan="1">ID</th>
                            <th rowspan="1" colspan="1">Nombre</th>
                            <th rowspan="1" colspan="1">Nacionalidad</th>
                            <th rowspan="1" colspan="1">Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($authors as $author) : ?>
                            <tr>
                                <td><?php echo $author['id_author']; ?></td>
                                <td><?php echo $author['last_name'] . " " . $author['name']; ?></td>
                                <td><?php echo $author['country']; ?></td>
                                <td class="text-center">
                                    <a href="#editAuthorModal<?php echo $author['id_author']; ?>" class="btn btn-primary edit-user" data-toggle="modal">
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

    <div class="modal fade" id="createAuthorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Nuevo autor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createAuthorForm" method="POST">
                        <div class="row">
                            <div class="form-group w-75 col-md-6">
                                <label for="lastNameAuthor">Apellido/s</label>
                                <input type="text" class="form-control" id="lastNameAuthor" name="lastNameAuthor" required>
                            </div>
                            <div class="form-group w-75 col-md-6">
                                <label for="nameAuthor">Nombre/s</label>
                                <input type="text" class="form-control" id="nameAuthor" name="nameAuthor" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group w-75 col-md-7">
                                <label for="fk_nationality_id">Nacionalidad </label>
                                <select class="form-control" name="fk_nationality_id" id="fk_nationality_id" required>
                                    <option value="" disabled selected>Seleccione una nacionalidad</option>
                                    <?php (new NationalityController())->allNationalitiesSelect(); ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" form="createAuthorForm" class="btn btn-primary" name="loadAuthor">Enviar</button>
                </div>
                <?php
                if (isset($_POST['loadAuthor'])) {
                    $controller = new AuthorController();
                    $controller->newAuthor();
                }
                ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createNationalityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Nueva nacionalidad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createNationalityForm" method="POST">
                        <div class="form-group w-75">
                            <label for="nationalityAuthor">País </label>
                            <input type="text" class="form-control" id="nationalityAuthor" name="nationalityAuthor" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" form="createNationalityForm" class="btn btn-primary" name="loadNationality">Enviar</button>
                </div>
                <?php
                if (isset($_POST['loadNationality'])) {
                    $controller = new NationalityController();
                    $controller->newNationality();
                }
                ?>
            </div>
        </div>
    </div>

    <?php foreach ($authors as $author) : ?>

        <div class="modal fade" id="editAuthorModal<?php echo htmlspecialchars($author['id_author']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Editar datos de autor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editAuthorForm<?php echo htmlspecialchars($author['id_author']); ?>" method="POST" action="index.php?pages=manageAuthors">
                            <input type="hidden" name="id_author" value="<?php echo $author['id_author']; ?>">
                            <div class="row">
                                <div class="form-group w-75 col-md-6">
                                    <label for="lastNameAuthor<?php echo htmlspecialchars($author['id_author']); ?>">Apellido/s</label>
                                    <input type="text" class="form-control" id="lastNameAuthor<?php echo htmlspecialchars($author['id_author']); ?>" name="lastNameAuthor" value="<?php echo htmlspecialchars($author['last_name']); ?>" required>
                                </div>
                                <div class="form-group w-75 col-md-6">
                                    <label for="nameAuthor<?php echo htmlspecialchars($author['id_author']); ?>">Nombre/s</label>
                                    <input type="text" class="form-control" id="nameAuthor<?php echo htmlspecialchars($author['id_author']); ?>" name="nameAuthor" value="<?php echo htmlspecialchars($author['name']); ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group w-75 col-md-7">
                                    <label for="fk_nationality_id<?php echo htmlspecialchars($author['id_author']); ?>">Nacionalidad </label>
                                    <select class="form-control" name="fk_nationality_id" id="fk_nationality_id<?php echo htmlspecialchars($author['id_author']); ?>" required>
                                        <?php (new NationalityController())->nationalitiesSelect($author['fk_nationality_id']); ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" form="editAuthorForm<?php echo htmlspecialchars($author['id_author']); ?>" class="btn btn-primary" name="changeAuthor">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach ?>

    <?php
    if (isset($_POST['changeAuthor'])) {
        $controller = new AuthorController();
        $controller->updateAuthor();
    }
