<?php
class IndexController
{
	public function run()
	{
		session_start();
		if (isset($_SESSION['fk_role_id']) && ($_SESSION['state'] == 1)) {

			include "views/base.php";
		} else {
			include "views/pages/login.php";
		}
	}
}
