<?php
if (
    ($_GET['pages'] == "home") ||
    ($_GET['pages'] == "manageEditorials")
    # links administracion de carreras
) {
    include "views/pages/" . $_GET['pages'] . ".php";
} elseif ($_GET['pages'] == "logout") {
    include "views/pages/logout.php";
} else {
    include "views/pages/error404.php";
}
