<?php $clients = ClientController::getAllClients(); ?>
<h1 class="h3 mb-4 text-gray-800">Gestión de clientes</h1>
<div class="d-flex justify-content-center">
    <div class="card shadow mb-4 col-sm-10 col-xl-11">
        <div class="card-header py-3 bg-white">
            <button class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#createClientModal" title="Crear cliente">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Nuevo cliente</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="ID: activate to sort column ascending" style="width: 55px;">ID</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Nombre: activate to sort column descending" aria-sort="ascending" style="width: 230px;">Nombre</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="DNI: activate to sort column ascending" style="width: 105px;">DNI</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 105px;">Email</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Dirección: activate to sort column ascending" style="width: 105px;">Dirección</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Estado: activate to sort column ascending" style="width: 105px;">Estado</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 45px;">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th rowspan="1" colspan="1">ID</th>
                            <th rowspan="1" colspan="1">Nombre</th>
                            <th rowspan="1" colspan="1">DNI</th>
                            <th rowspan="1" colspan="1">Email</th>
                            <th rowspan="1" colspan="1">Dirección</th>
                            <th rowspan="1" colspan="1">Estado</th>
                            <th rowspan="1" colspan="1">Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($clients as $client) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($client['id_client']); ?></td>
                                <td><?php echo htmlspecialchars($client['last_name']) . " " . htmlspecialchars($client['name']); ?></td>
                                <td><?php echo htmlspecialchars($client['dni']); ?></td>
                                <td><?php echo htmlspecialchars($client['email']); ?></td>
                                <td><?php echo htmlspecialchars($client['address']); ?></td>
                                <td><?php echo $client['state'] == 1 ? '<p style="color: green;">Activo</p>' : '<p style="color: red;">Inactivo</p>'; ?></td>
                                <td class="text-center">
                                    <a href="#editClientModal<?php echo htmlspecialchars($client['id_client']); ?>" class="btn btn-primary edit-user" data-toggle="modal">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <?php if ($client['state'] == 1) : ?>
                                        <a href="index.php?pages=manageClients&action=disableClient&id_client=<?php echo $client['id_client'] ?>" class="btn btn-success" title="Deshabilitar cliente"><i class="fas fa-toggle-on"></i></a>
                                    <?php else : ?>
                                        <a href="index.php?pages=manageClients&action=enableClient&id_client=<?php echo $client['id_client'] ?>" class="btn btn-danger" title="Habilitar cliente"><i class="fas fa-toggle-off"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['action'])) {
        if ($_GET['action'] == "disableClient") {
            $controller = new ClientController();
            $controller->disableClient();
        }

        if ($_GET['action'] == "enableClient") {
            $controller = new ClientController();
            $controller->enableClient();
        }
    }

    ?>

    <div class="modal fade" id="createClientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Nuevo cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createClientForm" method="POST" action="">
                        <div class="row">
                            <div class="form-group w-75 col-md-6">
                                <label for="lastNameClient">Apellido/s</label>
                                <input type="text" class="form-control" id="lastNameClient" name="lastNameClient" required>
                            </div>
                            <div class="form-group w-75 col-md-6">
                                <label for="nameClient">Nombre/s</label>
                                <input type="text" class="form-control" id="nameClient" name="nameClient" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group w-75 col-md-6">
                                <label for="dniClient">DNI</label>
                                <input type="number" class="form-control" id="dniClient" name="dniClient" required>
                            </div>
                            <div class="form-group w-75 col-md-6">
                                <label for="addressClient">Dirección</label>
                                <input type="text" class="form-control" id="addressClient" name="addressClient" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group w-75 col-md-12">
                                <label for="emailClient">Email</label>
                                <input type="email" class="form-control" id="emailClient" name="emailClient" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" form="createClientForm" class="btn btn-primary" name="loadClient">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_POST['loadClient'])) {
        $controller = new ClientController();
        $controller->newClient();
    } ?>

    <?php foreach ($clients as $client) : ?>

        <div class="modal fade" id="editClientModal<?php echo htmlspecialchars($client['id_client']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Editar datos de cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editClientForm<?php echo htmlspecialchars($client['id_client']); ?>" method="POST" action="">
                            <input type="hidden" name="id_client" value="<?php echo htmlspecialchars($client['id_client']); ?>">
                            <div class="row">
                                <div class="form-group w-75 col-md-6">
                                    <label for="lastNameClient<?php echo htmlspecialchars($client['id_client']); ?>">Apellido/s</label>
                                    <input type="text" class="form-control" id="lastNameClient<?php echo htmlspecialchars($client['id_client']); ?>" name="lastNameClient" value="<?php echo htmlspecialchars($client['last_name']); ?>" required>
                                </div>
                                <div class="form-group w-75 col-md-6">
                                    <label for="nameClient<?php echo htmlspecialchars($client['id_client']); ?>">Nombre/s</label>
                                    <input type="text" class="form-control" id="nameClient<?php echo htmlspecialchars($client['id_client']); ?>" name="nameClient" value="<?php echo htmlspecialchars($client['name']); ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group w-75 col-md-12">
                                    <label for="addressClient<?php echo htmlspecialchars($client['id_client']); ?>">Dirección</label>
                                    <input type="text" class="form-control" id="addressClient<?php echo htmlspecialchars($client['id_client']); ?>" name="addressClient" value="<?php echo htmlspecialchars($client['address']); ?>" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" form="editClientForm<?php echo htmlspecialchars($client['id_client']); ?>" class="btn btn-primary" name="changeClient">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

    <?php if (isset($_POST['changeClient'])) {
        $controller = new ClientController();
        $controller->updateClient();
    } ?>
</div>