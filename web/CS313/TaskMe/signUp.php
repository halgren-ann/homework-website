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
        <form action="verifySignUp.php" method="POST">
            <label>First Name:</label><br>
            <input type="text" name="first_name" placeholder="Enter first name" maxlength=16 required><br><br><br>
            <label>Last Name:</label><br>
            <input type="text" name="last_name" placeholder="Enter last name" maxlength=16 required><br><br><br>
            <label>Username:</label><br>
            <input type="text" name="username" placeholder="Enter new username" maxlength=16 required><br><br><br>
            <label>Password:</label><br>
            <input type="text" name="user_password" placeholder="Enter new password" maxlength=16 required><br><br><br>
            <select name="display_color" class="dropdown">
                <option value="default">Choose background display color</option>
                <option value="default">Keep this color</option>
                <option value="aqua">Aqua</option>
                <option value="gold">Gold</option>
                <option value="greenyellow">Green-yellow</option>
                <option value="lightslategray">Light Slate Gray</option>
                <option value="lightcoral">Light Coral</option>
            </select>
            <br><br><br>
            <input type="submit" style="width:100%">
        </form>
    </div>
    <div class="titleArea">
        <h1>TaskMe</h1>
    </div>
     
</body>
</html> 
