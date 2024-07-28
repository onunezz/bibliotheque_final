<?php $books = BookController::getAllBooks(); ?>
<h1 class="h3 mb-4 text-gray-800">Gestión de libros</h1>
<div class="d-flex justify-content-center">
    <div class="card shadow mb-4 col-sm-9 col-xl-10">
        <div class="card-header py-3 bg-white">
            <button class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#createBookModal" title="Crear libro">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Nuevo/s libro/s</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="ID: activate to sort column ascending" style="width: 55px;">ID</th>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Título: activate to sort column descending" aria-sort="ascending" style="width: 180px;">Título</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Código: activate to sort column ascending" style="width: 105px;">Código</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Cantidad: activate to sort column ascending" style="width: 105px;">Cantidad</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 45px;">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th rowspan="1" colspan="1">ID</th>
                            <th rowspan="1" colspan="1">Título</th>
                            <th rowspan="1" colspan="1">Código</th>
                            <th rowspan="1" colspan="1">Cantidad</th>
                            <th rowspan="1" colspan="1">Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($books as $book) : ?>
                            <tr>
                                <td><?php echo $book['id_book']; ?></td>
                                <td><?php echo $book['title']; ?></td>
                                <td><?php echo $book['abbreviature']; ?></td>
                                <td><?php echo $book['amount']; ?></td>
                                <td class="text-center">
                                    <a href="#infoBookModal<?php echo $book['id_book']; ?>" class="btn btn-success edit-user" data-toggle="modal">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#editBookModal<?php echo $book['id_book']; ?>" class="btn btn-primary edit-user" data-toggle="modal">
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

    <div class="modal fade" id="createBookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Nuevo/s libro/s</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createBookForm" method="POST">
                        <div class="row">
                            <div class="form-group w-75 col-md-12">
                                <label for="title">Título</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group w-75 col-md-6">
                                <label for="abbreviature">Abreviatura</label>
                                <input type="text" class="form-control" id="abbreviature" name="abbreviature" required>
                            </div>
                            <div class="form-group w-75 col-md-6">
                                <label for="amount">Cantidad</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            $bookController = new BookController();
                            $currentYear = $bookController->getCurrentYear();
                            ?>
                            <div class="form-group w-75 col-md-6">
                                <label for="publication_date">Año de publicación</label>
                                <input type="number" class="form-control" id="publication_date" name="publication_date" value="<?php echo $currentYear; ?>" required>
                            </div>
                            <div class="form-group w-75 col-md-6">
                                <label for="fk_author_id">Autor</label>
                                <select class="form-control" name="fk_author_id" id="fk_author_id" required>
                                    <option value="" disabled selected>Seleccione un autor</option>
                                    <?php (new AuthorController())->allAuthorsSelect(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group w-75 col-md-6">
                                <label for="fk_editorial_id">Editorial</label>
                                <select class="form-control" name="fk_editorial_id" id="fk_editorial_id" required>
                                    <option value="" disabled selected>Seleccione una editorial</option>
                                    <?php (new EditorialController())->allEditorialsSelect(); ?>
                                </select>
                            </div>
                            <div class="form-group w-75 col-md-6">
                                <label for="fk_category_id">Categoría</label>
                                <select class="form-control" name="fk_category_id" id="fk_category_id" required>
                                    <option value="" disabled selected>Seleccione categorías</option>
                                    <?php (new CategoryController())->allCategoriesSelect(); ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" form="createBookForm" class="btn btn-primary" name="loadBook">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['loadBook'])) {
        $controller = new BookController();
        $controller->newBook();
    }
    ?>

    <?php foreach ($books as $book) : ?>

        <div class="modal fade" id="infoBookModal<?php echo htmlspecialchars($book['id_book']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo htmlspecialchars($book['title']) . ' - ' . htmlspecialchars($book['abbreviature']); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Título:</strong> <?php echo htmlspecialchars($book['title']); ?></p>
                        <p><strong>Abreviatura:</strong> <?php echo htmlspecialchars($book['abbreviature']); ?></p>
                        <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($book['amount']); ?></p>
                        <p><strong>Año de publicación:</strong> <?php echo htmlspecialchars($book['publication_date']); ?></p>
                        <p><strong>Autor:</strong> <?php echo htmlspecialchars($book['name_author'] . ' ' . $book['last_name_author']); ?></p>
                        <p><strong>Editorial:</strong> <?php echo htmlspecialchars($book['name_editorial']); ?></p>
                        <p><strong>Categoría:</strong> <?php echo htmlspecialchars($book['description_category']); ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editBookModal<?php echo htmlspecialchars($book['id_book']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Editar libro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editBookForm<?php echo htmlspecialchars($book['id_book']); ?>" method="POST">
                            <input type="hidden" name="id_book" value="<?php echo htmlspecialchars($book['id_book']); ?>">
                            <div class="row">
                                <div class="form-group w-75 col-md-12">
                                    <label for="title<?php echo htmlspecialchars($book['id_book']); ?>">Título</label>
                                    <input type="text" class="form-control" id="title<?php echo htmlspecialchars($book['id_book']); ?>" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group w-75 col-md-6">
                                    <label for="abbreviature<?php echo htmlspecialchars($book['id_book']); ?>">Abreviatura</label>
                                    <input type="text" class="form-control" id="abbreviature<?php echo htmlspecialchars($book['id_book']); ?>" name="abbreviature" value="<?php echo htmlspecialchars($book['abbreviature']); ?>" required>
                                </div>
                                <div class="form-group w-75 col-md-6">
                                    <label for="amount<?php echo htmlspecialchars($book['id_book']); ?>">Cantidad</label>
                                    <input type="number" class="form-control" id="amount<?php echo htmlspecialchars($book['id_book']); ?>" name="amount" value="<?php echo htmlspecialchars($book['amount']); ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group w-75 col-md-6">
                                    <label for="publication_date<?php echo htmlspecialchars($book['id_book']); ?>">Año de publicación</label>
                                    <input type="number" class="form-control" id="publication_date<?php echo htmlspecialchars($book['id_book']); ?>" name="publication_date" value="<?php echo htmlspecialchars($book['publication_date']); ?>" required>
                                </div>
                                <div class="form-group w-75 col-md-6">
                                    <label for="fk_author_id<?php echo htmlspecialchars($book['id_book']); ?>">Autor</label>
                                    <select class="form-control" name="fk_author_id" id="fk_author_id<?php echo htmlspecialchars($book['id_book']); ?>" required>
                                        <?php (new AuthorController())->authorsSelect($book['fk_author_id']); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group w-75 col-md-6">
                                    <label for="fk_editorial_id<?php echo htmlspecialchars($book['id_book']); ?>">Editorial</label>
                                    <select class="form-control" name="fk_editorial_id" id="fk_editorial_id<?php echo htmlspecialchars($book['id_book']); ?>" required>
                                        <?php (new EditorialController())->editorialsSelect($book['fk_editorial_id']); ?>
                                    </select>
                                </div>
                                <div class="form-group w-75 col-md-6">
                                    <label for="fk_category_id<?php echo htmlspecialchars($book['id_book']); ?>">Categoría</label>
                                    <select class="form-control" name="fk_category_id" id="fk_category_id<?php echo htmlspecialchars($book['id_book']); ?>" required>
                                        <?php (new CategoryController())->categoriesSelect($book['fk_category_id']); ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" form="editBookForm<?php echo htmlspecialchars($book['id_book']); ?>" class="btn btn-primary" name="changeBook">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>


    <?php endforeach ?>

    <?php
    if (isset($_POST['changeBook'])) {
        $controller = new BookController();
        $controller->updateBook();
    }
