<?php
    session_start();
    include 'dbConnect.php';
    require 'password.php';
?>

<!DOCTYPE html>
<html>
<head></head>
<body>

<?php
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

    //check for username uniqueness
    $stmt = $db->prepare('SELECT * FROM public.user WHERE username = :username');
    $stmt->execute(array(':username' => $username));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows[0]) {
        //this username already exists in the database
        echo "<script type='text/javascript'>alert('Sorry, that username is already taken by another user');
        window.location = 'signUp.php';</script>";
        die();
    }

    //Fix display_color
    if ($display_color == "default") {
        $display_color = "#257";
    }

    //prepare hashed password
    $passwordHash = password_hash($user_password, PASSWORD_DEFAULT);

    //Insert into the database
    $stmt = $db->prepare('INSERT into public.user(username, user_password, first_name, last_name, display_color) 
        VALUES (:username, :user_password, :first_name, :last_name, :display_color);');
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':user_password', $passwordHash, PDO::PARAM_STR);
    $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindValue(':display_color', $display_color, PDO::PARAM_STR);
    $stmt->execute();

    //also capture the user's id for use in this session
    $stmt = $db->prepare('SELECT * FROM public.user WHERE username = :username AND user_password = :user_password');
    $stmt->execute(array(':username' => $username, ':user_password' => $passwordHash));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION["user_id"] = $rows[0]["id"];
    //redirect the page to TaskMe.php
    header("Location: TaskMe.php");
    die();
?>

</body>
</html>