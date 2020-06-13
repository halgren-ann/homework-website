<!DOCTYPE html>
<html>
<head></head>
<body>

<?php 
    include 'dbConnect.php';
    require("sendgrid-php/sendgrid-php/sendgrid-php.php");

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

    //Couple the attendee with the classes they registered for, and save the info for the email
    $emailClassContent = null;
    foreach($_POST as $key => $value)
    {
        if (is_numeric($key))
        {
            $stmt = $db->prepare('INSERT into public.registered(attendee_id, class_id) 
                VALUES (:attendee_id, :class_id);');
            $stmt->execute(array(':attendee_id' => $attendee_id, ':class_id' => $key));
            $stmt->fetchAll(PDO::FETCH_ASSOC);

            //For email purposes
            $stmt = $db->prepare('SELECT * FROM public.class(class_time, topic, teacher, link, additional_materials) 
                WHERE id=:id;');
            $stmt->execute(array(':id' => $key));
            $classContent = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $emailClassContent += "Class time: " . $classContent[0]["class_time"] . "\n";
            $emailClassContent += "Topic: " . $classContent[0]["topic"] . "\n";
            $emailClassContent += "Teacher: " . $classContent[0]["teacher"] . "\n";
            $emailClassContent += "Link: " . $classContent[0]["link"] . "\n";
            $emailClassContent += "Any Additional Materials: " . $classContent[0]["additional_materials"] . "\n\n";
        }
    }

    /////////////////////////////////////////////////////////////////////
    //Send an email with the info about the classes they signed up for
    
    $from = new SendGrid\Email(null, "annabellelarsen@gmail.com");
    $subject = "Family History Conference Registration";
    $to = new SendGrid\Email(null, $_POST["email"]);

    //Create the content of the email
    $contentStr = "Hi " . $_POST["full_name"] . ",\n\nThank you for registering for Family History Conference.";
    $contentStr += "Below are the classes you are registered for that will take place on Saturday January 2021.";
    $contentStr += "If you change your mind and would like to sign up for a different set of classes, ";
    $contentStr += "just return to (link website here) and register again. Your class select will be reset with ";
    $contentStr += "the new information.\n\n";
    //$contentStr += $emailClassContent;
    $contentStr += "If you have any questions, please contact (contact info here). We look forward to seeing you!";

    echo "\ncontentStr before wordwrap: " . $contentStr;
    $contentStr = wordwrap($contentStr,70);
    echo "\ncontentStr after wordwrap: " . $contentStr;
    echo "\nemailClassContent: " . $emailClassContent;

    $content = new SendGrid\Content("text/plain", $contentStr);
    $mail = new SendGrid\Mail($from, $subject, $to, $content);

    $apiKey = getenv('SENDGRID_API_KEY');
    $sg = new \SendGrid($apiKey);

    $response = $sg->client->mail()->send()->post($mail);
    echo $response->statusCode();
    echo $response->headers();
    echo $response->body();
    ///////////////////////////////////////////////////////////////////

    //Redirect back to the main page   
    //header("Location:index.php");
?>

</body>
</html>