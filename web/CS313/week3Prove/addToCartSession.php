<?php
    session_start();

    $q = $_REQUEST["q"]; //$q holds the item name

    if (isset($_SESSION["items"][$q])) {
        $_SESSION["items"][$q]++;
    }
    else {
        $_SESSION["items"][$q] = 1;
    }
?>