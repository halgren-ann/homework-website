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

    $stmt = $db->prepare('INSERT into public.user(username, user_password, first_name, last_name, display_color) 
        VALUES (:username, :user_password, :first_name, :last_name, :display_color);');
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':user_password', $user_password, PDO::PARAM_STR);
    $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindValue(':display_color', $display_color, PDO::PARAM_STR);
    $stmt->execute();

    //PREPARE fooplan (int, text, bool, numeric) AS
    //INSERT INTO foo VALUES($1, $2, $3, $4);
    //EXECUTE fooplan(1, 'Hunter Valley', 't', 200.00);

    /*
    //now insert the values into the database
    $stmt = $db->prepare('INSERT into public.user(username, user_password, first_name, last_name, display_color) 
        VALUES (:username, :user_password, :first_name, :last_name, :display_color);');
    $stmt->execute(array(':username' => $username, ':user_password' => $user_password, ':first_name' => $first_name, ':last_name' => $last_name, ':display_color' => $display_color);
    //also capture the user's id for use in this session
    $_SESSION["user_id"] = $pdo->lastInsertId('public.user_id_seq');
    //redirect the page to TaskMe.php
    header(‘Location: TaskMe.php’);
    die();
    */
?>