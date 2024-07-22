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
					if (isset($_GET['page'])) {
						if (($_GET['page'] == "home")
							#	|| ($_GET['page'] == "") 
						) {

							include "../views/pages/" . $_GET['page'] . ".php";
						} else {

							include "../views/error404.php";
						}
					} else {

						include "../views/pages/home.php";
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<?php //include_once '../views/base/footer.php' 
	?>
	<?php include_once '../views/base/scripts.php' ?>
</body>

</html>