<!DOCTYPE html>
<html>
<head>
	<?php include_once '../views/base/head.php'?>
</head>
<body>	
	<div>
		<div>
			<?php
			if(isset($_GET['page'])) {
				if( ($_GET['page'] == "home") 
				#	|| ($_GET['page'] == "") 
					) {

					include "../views/pages/".$_GET['page'].".php";

				} else {

					include "../views/error404.php";

				}

			} else {

				include "../views/pages/home.php";

			}				
			?>
		</div>
		<?php include_once '../views/base/footer.php'?>
	</div>	
	<?php include_once '../views/base/scripts.php'?>
</body>
</html>