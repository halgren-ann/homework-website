<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head></head>
<body>

<?php
     try {
        $dbUrl = getenv('DATABASE_URL');

        $dbOpts = parse_url($dbUrl);

        $dbHost = $dbOpts["host"];
        $dbPort = $dbOpts["port"];
        $dbUser = $dbOpts["user"];
        $dbPassword = $dbOpts["pass"];
        $dbName = ltrim($dbOpts["path"],'/');

        $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $ex) {
        echo 'Error!: ' . $ex->getMessage();
        die();
    }

    // define variables and set to empty values
    $username = $_POST["username"];
    $user_password = $_POST["user_password"];

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

    //Queries
    foreach ($db->query('SELECT id, username, user_password FROM public.user WHERE username = ' . $username) as $row) {
        if($row->rowCount() > 0) {
            if($user_password == $row['user_password']) {
                //Then they check out with the database

                //Move on to the home page
                echo "<script type='text/javascript'>window.location = 'TaskMe.php';</script>";
            }
            else {
                echo "<script type='text/javascript'>alert('Sorry, the password is incorrect');
                window.location = 'login.php';</script>";
            }
        }
        else {
            echo "<script type='text/javascript'>alert('Sorry, the username is incorrect. Please either enter a different username or go back to the previous page and click Sign Up');
            window.location = 'login.php';</script>";
        }
    }

    //Prepared statements
    $stmt = $db->prepare('SELECT id, username, user_password FROM public.user WHERE username=:username AND user_password=:user_password');
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':user_password', $user_password, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo $row['id'];
?>

</body>
</html>