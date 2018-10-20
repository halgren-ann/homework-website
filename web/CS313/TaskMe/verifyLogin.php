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

    

    //Prepared statements
    $stmt = $db->prepare('SELECT id, username, user_password FROM public.user WHERE username=:username');
    $stmt->bindValue(':username', $username, PDO::PARAM_VARCHAR);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo $row['id'];
?>

</body>
</html>