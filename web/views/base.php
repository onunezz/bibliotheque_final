<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
	<?php include_once 'base/head.php'; ?>
</head>

<body id="page-top">
	<div id="wrapper">
		<?php include_once 'base/sidebar.php'; ?>
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				<?php include_once 'base/navbar.php'; ?>
				<div class="container-fluid">
					<?php
					if (isset($_GET['pages']) && (isset($_SESSION['fk_role_id']))) {
						switch ($_SESSION['fk_role_id']) {
							case 1:
								include_once "getRoles/getAdminRol.php";
								break;
							case 2:
								include_once "getRoles/getLibrarianRol.php";
								break;
						}
					} else {
						include "views/pages/home.php";
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php //include_once '../views/base/footer.php' 
	?>
	<?php include_once 'base/scripts.php' ?>
</body>

</html>