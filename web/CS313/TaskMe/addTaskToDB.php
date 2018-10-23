<?php
    session_start();
    include 'dbConnect.php';

    //test for malicious injection
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $task = test_input($_POST["task"]);
        if (isset($_POST["subtask1"])) {$subtask1 = test_input($_POST["subtask1"]);}
        //if (isset($_POST["subtask2"])) {$subtask2 = test_input($_POST["subtask2"]);}
        $subtask2 = test_input($_POST["subtask2"]);
        //if (isset($_POST["subtask3"])) {$subtask3 = test_input($_POST["subtask3"]);}
        $subtask3 = test_input($_POST["subtask3"]);
        //if (isset($_POST["subtask4"])) {$subtask4 = test_input($_POST["subtask4"]);}
        $subtask4 = test_input($_POST["subtask4"]);
        $classification = test_input($_POST["classification"]);
        $difficulty = test_input($_POST["difficulty"]);
        //if (isset($_POST["date_due_month"])) {$date_due_month = test_input($_POST["date_due_month"]);}
        $date_due_month = test_input($_POST["date_due_month"]);
        //if (isset($_POST["date_due_day"])) {$date_due_day = test_input($_POST["date_due_day"]);}
        $date_due_day = test_input($_POST["date_due_day"]);
        //if (isset($_POST["date_due_year"])) {$date_due_year = test_input($_POST["date_due_year"]);}
        $date_due_year = test_input($_POST["date_due_year"]);
    }

    echo $task . $subtask1 . $subtask2 . $subtask3 . $subtask4 . $classification . $difficulty . $date_due_month . $date_due_day . $date_due_year;

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //Insert the main task into the database
    //$stmt = $db->prepare('INSERT into public.task(user_id, task_text, date_added, date_due, classification, difficulty, is_complete) 
    //    VALUES (:user_id, :task_text, :date_added, :date_due, :classification, :difficulty, :is_complete);');
    //$stmt->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
    //$stmt->bindValue(':task_text', $task, PDO::PARAM_STR);
    //$stmt->bindValue(':date_added', current_timestamp, PDO::PARAM_DATE);
    //$stmt->bindValue(':date_due', echo $date_due_year . "-" . $date_due_month . "-" . $date_due_day, PDO::PARAM_DATE);
    //$stmt->bindValue(':classification', $classification, PDO::PARAM_STR);
    //$stmt->bindValue(':difficulty', $difficulty, PDO::PARAM_STR);
    //$stmt->bindValue(':is_complete', 'false', PDO::PARAM_STR);
    //$stmt->execute();
?>