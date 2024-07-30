<?php $loans = LoanController::getAllLoans(); ?>
<?php
if (isset($_GET['action']) && $_GET['action'] == "loanPdf" && isset($_GET['id_loan']) && isset($_GET['last_name_client'])) {
    (new PdfController())->loanPdf($_GET['id_loan'], $_GET['last_name_client']);
}
?>

<h1 class="h3 mb-4 text-gray-800">Gestión de préstamos</h1>
<div class="d-flex justify-content-center">
    <div class="card shadow mb-4 col-sm-12 col-xl-12">
        <div class="card-header py-3 bg-white">
            <button class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#createLoanModal" title="Crear préstamo">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Nuevo préstamo</span>
            </button>
            <button class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#quickCreateClientModal" title="Crear cliente">
                <span class="icon text-white-50">
                    <i class="fas fa-user"></i>
                </span>
                <span class="text">Registro rápido de cliente</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting sorting_desc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="ID: activate to sort column ascending" aria-sort="descending" style="width: 55px;">ID</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Cliente: activate to sort column descending" style="width: 110px;">Cliente</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Libro: activate to sort column ascending" style="width: 125px;">Libro</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Fecha de préstamo: activate to sort column ascending" style="width: 105px;">Fecha de préstamo</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Fecha de devolución: activate to sort column ascending" style="width: 105px;">Fecha de devolución</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Cantidad: activate to sort column ascending" style="width: 25px;">Cantidad</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Estado: activate to sort column ascending" style="width: 85px;">Estado</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 45px;">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th rowspan="1" colspan="1">ID</th>
                            <th rowspan="1" colspan="1">Cliente</th>
                            <th rowspan="1" colspan="1">Libro</th>
                            <th rowspan="1" colspan="1">Fecha de préstamo</th>
                            <th rowspan="1" colspan="1">Fecha de devolución</th>
                            <th rowspan="1" colspan="1">Cantidad</th>
                            <th rowspan="1" colspan="1">Estado</th>
                            <th rowspan="1" colspan="1">Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($loans as $loan) : ?>
                            <tr>
                                <td><?php echo $loan['id_loan']; ?></td>
                                <td><?php echo $loan['last_name_client'] . " " . $loan['name_client']; ?></td>
                                <td><?php echo $loan['title']; ?></td>
                                <td><?php echo $loan['loan_date']; ?></td>
                                <td><?php echo $loan['return_date']; ?></td>
                                <td><?php echo $loan['amount']; ?></td>
                                <td class="text-center"><?php echo $loan['state'] == 1 ? '<span class="badge badge-pill badge-secondary">Prestado</span>' : '<span class="badge badge-pill badge-success">Devuelto</span>'; ?></td>
                                <td class="text-center">
                                    <?php if ($loan['state'] == 1) : ?>
                                        <a href="index.php?pages=manageLoans&action=returnCheck&id_loan=<?php echo $loan['id_loan'] ?>" class="btn btn-success edit-user">
                                            <i class="fas fa-thumbs-up"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="index.php?pages=manageLoans&action=loanPdf&id_loan=<?php echo $loan['id_loan']; ?>&last_name_client=<?php echo urlencode($loan['last_name_client']); ?>" target="_blank" class="btn btn-danger edit-user" title="Descargar PDF del préstamo">
                                        <i class="fas fa-file-pdf"></i>
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
        if ($_GET['action'] == "returnCheck") {
            $controller = new LoanController();
            $controller->returnCheck();
        }
    }
    ?>

    <div class="modal fade" id="createLoanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Nuevo préstamo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createLoanForm" method="POST">
                        <div class="row">
                            <div class="form-group w-75 col-md-12">
                                <label for="fk_client_id">Cliente</label>
                                <select class="form-control" name="fk_client_id" id="fk_client_id" required>
                                    <option value="" disabled selected>Seleccione un cliente</option>
                                    <?php (new ClientController())->allClientsSelect(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group w-75 col-md-6">
                                <label for="fk_book_id">Libro</label>
                                <select class="form-control" name="fk_book_id" id="fk_book_id" required>
                                    <option value="" disabled selected>Seleccione un libro</option>
                                    <?php (new BookController())->allBooksSelect(); ?>
                                </select>
                            </div>
                            <div class="form-group w-75 col-md-6">
                                <label for="amount">Cantidad</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group w-75 col-md-6">
                                <label for="loan_date">Fecha del préstamo</label>
                                <input type="date" class="form-control" id="loan_date" name="loan_date" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="form-group w-75 col-md-6">
                                <label for="return_date">Fecha de devolución</label>
                                <input type="date" class="form-control" id="return_date" name="return_date" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" form="createLoanForm" class="btn btn-primary" name="loadLoan">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['loadLoan'])) {
        $controller = new LoanController();
        $controller->newLoan();
    }
    ?>

    <div class="modal fade" id="quickCreateClientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Nuevo cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="quickCreateClientForm" method="POST" action="">
                        <div class="row">
                            <div class="form-group w-75 col-md-12">
                                <label for="lastNameClient">Apellido/s</label>
                                <input type="text" class="form-control" id="lastNameClient" name="lastNameClient" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group w-75 col-md-6">
                                <label for="dniClient">DNI</label>
                                <input type="number" class="form-control" id="dniClient" name="dniClient" required>
                            </div>
                            <div class="form-group w-75 col-md-6">
                                <label for="emailClient">Email</label>
                                <input type="email" class="form-control" id="emailClient" name="emailClient" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" form="quickCreateClientForm" class="btn btn-primary" name="quickLoadClient">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_POST['quickLoadClient'])) {
        $controller = new ClientController();
        $controller->quickNewClient();
    } ?>