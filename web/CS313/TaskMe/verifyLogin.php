<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head></head>
<body>

<?php
    //connect to the database
    include 'dbConnect.php';
    require 'password.php';

    // define variables
    $username = $_POST["username"];
    $user_password = $_POST["user_password"];

    //test for malicious injection
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = test_input($_POST["username"]);
        $user_password = test_input($_POST["user_password"]);
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //check the login information
    $stmt = $db->prepare('SELECT * FROM public.user WHERE username = :username');
    $stmt->execute(array(':username' => $username));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rows[0]) {
        //check against the hashed password now
        if (password_verify($user_password, $rows[0]["user_password"])) {
            //Then they check out in the database
            $_SESSION["user_id"] = $rows[0]["id"];
            $_SESSION["color"] = $rows[0]["display_color"];
            //Move on to the home page
            echo "<script type='text/javascript'>window.location = 'TaskMe.php';</script>";
            die();
        }
        else {
            //some login info was incorrect
            echo "<script type='text/javascript'>alert('Sorry, the username or password is incorrect');
            window.location = 'login.php';</script>";
            die();
        }
    }
    else {
        //some login info was incorrect
        echo "<script type='text/javascript'>alert('Sorry, the username or password is incorrect');
        window.location = 'login.php';</script>";
        die();
    }
?>

</body>
</html>