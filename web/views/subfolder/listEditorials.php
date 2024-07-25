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
            <div class="table-responsive overflow-hidden">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="ID: activate to sort column ascending" style="width: 149px;">ID</th>
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
                                            <td><?php echo $editorial['state'] == 1 ? 'Activa' : 'Inactiva'; ?></td>
                                            <td>Editar Deshabilitar</td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                <form id="createEditorialForm">
                    <div class="form-group">
                        <label for="editorialName">Nombre </label>
                        <input type="text" class="form-control" id="editorialName" name="editorialName" placeholder="Ingrese el nombre de la editorial" required>
                    </div>

                    <div class="response-message text-center"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" form="createEditorialForm" class="btn btn-primary" name="loadEditorial">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>