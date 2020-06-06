<!DOCTYPE html>
<?php 
    include 'dbConnect.php';
    //Get the class list from the database to display in the table
    $stmt = $db->prepare('SELECT * FROM public.class ORDER BY class_time ASC;');
    $stmt->execute();
    $classList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //WORK DONE WHEN FORM IS SUBMITTED FOR REGISTRATION
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
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Family History Conference</title>
    <link rel="stylesheet" type="text/css" href="styles.css">    
</head>
<body>
    <form action="<?php=$_SERVER['PHP_SELF'];?>" method="post">
    <div id="opaqueContentBox" class="centered"></div>
    <h1 class="centered" id="title">Family History Conference</h1>
    <br/><br/><br/>
    <h2 class="centered" id="date">January 2021</h2>
    <br/><br/><br/>
    <section class="centered" id="registerHereSection">
        <h3>Want to participate? Register Here.</h3>
        <button id="goToRegisterPortion" onclick="openRegisterPopupSection()">Register</button>
    </section>
    <br/><br/><br/>
    <section class="hidden" id="registerPopupSection">
        <img src="x-2.png" id="x" onclick="closeRegisterPopupSection()">
        <br/>
        <label for="full_name">Full name:</label>
        <input type="text" id="full_name" name="full_name" autofocus>
        <br/>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <p>Check the boxes below next to the classes you would like to register for, then hit "Submit". You will receive an email with the information. If you want to change your class choices later, just come back here and register again.</p>
        <input type="submit" value="Submit">
    </section>
    <br/><br/><br/>
    <section class="centered" id="tableOfClassesSection">
        <table>
            <tr>
                <th class="registrationCol" id="checkboxCol"></th>
                <th id="timeCol">Time</th>
                <th id="topicCol">Topic</th>
                <th id="teacherCol">Teacher</th>
                <th id="zoomCol">Zoom Link</th>
                <th id="additionalCol">Additional Materials</th>
            </tr>
            <?php
                for ($i=0; $i < sizeof($rows); $i++) {
                    echo '
                        <tr>
                        <td class=registrationCol style="padding: 2px"><input type="checkbox" name="' . $classList[$i]["id"] . '"></td>
                        <td>' . date("h:i a", strtotime($classList[$i]["class_time"])) . '</td>
                        <td>' . $classList[$i]["topic"] . '</td>
                        <td>' . $classList[$i]["teacher"] . '</td>
                        <td><a href="' . $classList[$i]["link"] . '">' . $classList[$i]["link"] . '</a></td>
                        <td>' . $classList[$i]["additional_materials"] . '</td>
                        </tr>
                    ';
                }
            ?>
        </table>
    </section>
    </form>
</body>
<footer>
    <script src="script.js"></script>
</footer>
</html>