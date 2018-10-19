<?php
    session_start();
    echo "

<!DOCTYPE html>
<html>
<head>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Checkout</title>
    <link href='styles.css' rel='stylesheet'>
</head>
<body>
    <div class='centered'>
        <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]); . "'>
            <h2>Please enter your address below</h2><br>
            <label>Apartment or home number:</label><br>
            <input type='text' name='apt' placeholder='example: 443' maxlength=8 required><br><br><br>
            <label>Street name:</label><br>
            <input type='text' name='street' placeholder='example: Willow Road' maxlength=16 required><br><br><br>
            <label>City:</label><br>
            <input type='text' name='city' placeholder='example: Denver' maxlength=16 required><br><br><br>
            <label>State:</label><br>
            <input type='text' name='state' placeholder='example: CA or California' maxlength=16 required><br><br><br>
            <label>Zip code:</label><br>
            <input type='text' name='zip' placeholder='example: 55555' maxlength=10 required><br><br><br>
            <h2>You are about to buy " . $_SESSION["numItems"] . " items for \$" . $_SESSION["totalPrice"] . ".</h2>
            <br>
            <input type='button' value='Return to Cart' onclick='history.back(-1)' />
            <input type='submit'><br><br><br>
        </form>
    </div>
     
</body>
</html> 

";
?>
