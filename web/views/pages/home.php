<section class="container">
    <div class="row justify-content-center mt-5 pt-5">
        <div class="col-xl-6 col-lg-6 col-md-9">

            <h1 class="h1-home">bibliotheque</h1>
            <h2>Administración y préstamos de libros</h2>
            <?php

            require_once __DIR__ . '/../../config/MysqlDb.php'; // Asegúrate de poner la ruta correcta a tu archivo MysqlDb.php

            // Llama al método testConnection
            MysqlDb::testConnection();

            ?>
        </div>

    </div>

</section>