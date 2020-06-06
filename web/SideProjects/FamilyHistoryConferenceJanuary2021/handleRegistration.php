<!DOCTYPE html>
<html>
<head></head>
<body>

<?php 
    include 'dbConnect.php';

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

    //Redirect back to the main page and let them know if registration was successful
    echo "<script type='text/javascript'>alert('Congratulations, you're registered!');
        window.location = 'index.php';</script>";
    die();
?>

</body>
</html>