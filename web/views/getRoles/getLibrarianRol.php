<?php
if (
    ($_GET['pages'] == "home") ||
    ($_GET['pages'] == "manageEditorials") ||
    ($_GET['pages'] == "manageAuthors") ||
    ($_GET['pages'] == "manageBooks") ||
    ($_GET['pages'] == "manageClients") ||
    ($_GET['pages'] == "manageLoans") ||
    ($_GET['pages'] == "manageUsers") ||
    ($_GET['pages'] == "changePasswordStart")
) {
    include "views/pages/" . $_GET['pages'] . ".php";
} elseif ($_GET['pages'] == "logout") {
    include "views/pages/logout.php";
} else {
    include "views/pages/error404.php";
}