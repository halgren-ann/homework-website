<?php
    session_start();
    unset($_SESSION['user_id']);
    unset($_SESSION["color"]);
    header("Location: index.html");
    die();
?>