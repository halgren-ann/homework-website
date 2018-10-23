<?php
    session_start();
    include 'dbConnect.php';

    // define variables
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $username = $_POST["username"];
    $user_password = $_POST["user_password"];
    $display_color = $_POST["display_color"];

    //test for malicious injection
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name =test_input($_POST["first_name"]);
        $last_name = test_input($_POST["last_name"]);
        $username = test_input($_POST["username"]);
        $user_password = test_input($_POST["user_password"]);
        $display_color = test_input($_POST["display_color"]);
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    echo "$first_name\n$last_name\n$username\n$user_password\n$display_color";

    //PREPARE fooplan (int, text, bool, numeric) AS
    //INSERT INTO foo VALUES($1, $2, $3, $4);
    //EXECUTE fooplan(1, 'Hunter Valley', 't', 200.00);

    
?>