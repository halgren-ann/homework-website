<!DOCTYPE html>
<html>
<head></head>
<body>

<?php 
    include 'dbConnect.php';
    require("C:\Users\David Halgren\Desktop\sendgrid-php\sendgrid-php\sendgrid-php.php");

    //Add new attendee
    $stmt = $db->prepare('INSERT into public.attendee(full_name, email) 
        VALUES (:full_name, :email);');
    $stmt->execute(array(':full_name' => $_POST["full_name"], ':email' => $_POST["email"]));
    $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Grab the attendee's id
    $stmt = $db->prepare('SELECT * FROM public.attendee WHERE email =:email;');
    $stmt->execute(array(':email' => $_POST["email"]));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $attendee_id = $rows[0]["id"];

    //Couple the attendee with the classes they registered for
    foreach($_POST as $key => $value)
    {
        if (is_numeric($key))
        {
            $stmt = $db->prepare('INSERT into public.registered(attendee_id, class_id) 
                VALUES (:attendee_id, :class_id);');
            $stmt->execute(array(':attendee_id' => $attendee_id, ':class_id' => $key));
            $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    //Send an email with the info about the classes they signed up for
    /*// the message
    $msg = "Hi Developer!";

    // use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);

    // send email
    if(mail("annabellelarsen@gmail.com","Test",$msg)) {
        //Redirect back to the main page   
        header("Location:index.php");
    }*/
    $from = new SendGrid\Email(null, "annabellelarsen@gmail.com");
    $subject = "Hello World from the SendGrid PHP Library!";
    $to = new SendGrid\Email(null, "annabellelarsen@gmail.com");
    $content = new SendGrid\Content("text/plain", "Hello, Email!");
    $mail = new SendGrid\Mail($from, $subject, $to, $content);

    $apiKey = getenv('SENDGRID_API_KEY');
    $sg = new \SendGrid($apiKey);

    $response = $sg->client->mail()->send()->post($mail);
    echo $response->statusCode();
    echo $response->headers();
    echo $response->body();
    ///////////////////////////////////////////////////////////////////

    /*//Redirect back to the main page   
    header("Location:index.php");*/
?>

</body>
</html>