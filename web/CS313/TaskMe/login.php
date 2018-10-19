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
        echo "Connected to the db successfully";
    }
    catch (PDOException $ex) {
        echo 'Error!: ' . $ex->getMessage();
        die();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskMe</title>
    <link href="https://fonts.googleapis.com/css?family=Yesteryear" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Caveat" rel="stylesheet">
    <link href="whole-styles.css" rel="stylesheet">
</head>
<body>
    <div class="centered">
        <br><br><br><br><br><br>
        <label>Username:</label><br>
        <input type="text" name="username" placeholder="Enter username" maxlength=16 required><br><br><br>
        <label>Password:</label><br>
        <input type="text" name="user_password" placeholder="Enter password" maxlength=16 required><br><br><br>
        <input type="submit" style="width:100%">
    </div>
    <div class="titleArea">
        <h1>TaskMe</h1>
    </div>
     
</body>
</html> 
