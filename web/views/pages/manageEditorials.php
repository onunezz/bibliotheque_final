<?php
if (isset($_GET['subfolder'])) {
    if (($_GET['subfolder'] == "listEditorials" || $_GET['subfolder'] == "newEditorial")) {
        include "views/subfolder/" . $_GET['subfolder'] . ".php";
    }
} else {
    include "views/subfolder/listEditorials.php";
}
