<!DOCTYPE html>
<?php 
    include 'dbConnect.php';
    $stmt = $db->prepare('SELECT * FROM public.class;');
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Family History Conference</title>
    <link rel="stylesheet" type="text/css" href="styles.css">    
</head>
<body>
    <div id="opaqueContentBox" class="centered"></div>
    <h1 class="centered" id="title">Family History Conference</h1>
    <br/><br/><br/>
    <h2 class="centered" id="date">January 2021</h2>
    <br/><br/><br/>
    <section class="centered" id="registerHereSection">
        <h3>Want to participate? Register Here.</h3>
        <button id="goToRegisterPortion" onclick="registerButtonClicked()">Register</button>
    </section>
    <br/><br/><br/>
    <section class="centered hidden" id="registerPopupSection">
        <img src="x.png" id="x">
        <label for="full_name">Full name:</label>
        <input type="text" id="full_name" name="full_name">
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
                        <td class=registrationCol style="padding: 2px"><input type="checkbox" name="' . $rows[$i]["id"] . '"></td>
                        <td>' . $rows[$i]["class_time"] . '</td>
                        <td>' . $rows[$i]["topic"] . '</td>
                        <td>' . $rows[$i]["teacher"] . '</td>
                        <td><a href="' . $rows[$i]["link"] . '">' . $rows[$i]["link"] . '</a></td>
                        <td>' . $rows[$i]["additional_materials"] . '</td>
                        </tr>
                    ';
                }
            ?>
            <!--<tr>
                <td>10:00 am</td>
                <td>Intro to Family Search</td>
                <td>John Halgren</td>
                <td><a href="blahblah.zoom.com">blahblah.zoom.com</a></td>
                <td>N/A</td>
            </tr>
            <tr>
                <td>10:30 am</td>
                <td>Finding Joy in Your Heritage</td>
                <td>LeAnn Halgren</td>
                <td><a href="example.zoom.com">example.zoom.com</a></td>
                <td>Link to Google Drive with powerpoint slides</td>
            </tr>-->
        </table>
    </section>
</body>
</html>