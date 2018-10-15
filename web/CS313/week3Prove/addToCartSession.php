<?php
    session_start();

    $q = $_REQUEST["q"]; //$q holds the item name

    if (isset($_SESSION["items"][$q])) {
        $_SESSION["items"][$q]++;
    }
    else {
        $_SESSION["items"][$q] = 1;
    }

    /*
    if (isset($_POST["item"])) {
        $name = $_POST["item"];
        if (isset($_SESSION["items"][$name])) {
            $_SESSION["items"][$name]++;
        }
        else {
            $_SESSION["items"][$name] = 1;
        }
    }
    */
?>