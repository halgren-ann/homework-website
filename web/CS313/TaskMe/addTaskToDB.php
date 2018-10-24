<?php
    session_start();
    include 'dbConnect.php';

    //test for malicious injection
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $task = test_input($_POST["task"]);
        $subtask1 = test_input($_POST["subtask1"]);
        $subtask2 = test_input($_POST["subtask2"]);
        $subtask3 = test_input($_POST["subtask3"]);
        $subtask4 = test_input($_POST["subtask4"]);
        $classification = test_input($_POST["classification"]);
        $difficulty = test_input($_POST["difficulty"]);
        $date_due_month = test_input($_POST["date_due_month"]);
        $date_due_day = test_input($_POST["date_due_day"]);
        $date_due_year = test_input($_POST["date_due_year"]);
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $totalDate = $date_due_year . "-" . $date_due_month . "-" . $date_due_day;

    //insert the main task
    $stmt = $db->prepare('INSERT into public.task(user_id, task_text, date_added, date_due, classification, difficulty, is_complete) 
        VALUES (:user_id, :task_text, :date_added, :date_due, :classification, :difficulty, :is_complete);');
    $stmt->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
    $stmt->bindValue(':task_text', $task, PDO::PARAM_STR);
    $stmt->bindValue(':date_added', date('Y-m-d'), PDO::PARAM_STR);
    $stmt->bindValue(':date_due', date('Y-m-d', strtotime($totalDate)), PDO::PARAM_STR);
    $stmt->bindValue(':classification', $classification, PDO::PARAM_STR);
    $stmt->bindValue(':difficulty', $difficulty, PDO::PARAM_STR);
    $stmt->bindValue(':is_complete', 'false', PDO::PARAM_STR);
    $stmt->execute();

    //capture this task_id
    $task_id = $db->lastInsertId('task_id_seq');

    //insert any subtasks
    if ($subtask1 != "") {
        $stmt = $db->prepare('INSERT into public.subtask(user_id, task_id, task_text, is_complete) 
            VALUES (:user_id, :task_id, :task_text, :is_complete);');
        $stmt->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
        $stmt->bindValue(':task_id', $task_id, PDO::PARAM_STR);
        $stmt->bindValue(':task_text', $subtask1, PDO::PARAM_STR);
        $stmt->bindValue(':is_complete', 'false', PDO::PARAM_STR);
        $stmt->execute();
    }
    if ($subtask2 != "") {
        $stmt = $db->prepare('INSERT into public.subtask(user_id, task_id, task_text, is_complete) 
            VALUES (:user_id, :task_id, :task_text, :is_complete);');
        $stmt->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
        $stmt->bindValue(':task_id', $task_id, PDO::PARAM_STR);
        $stmt->bindValue(':task_text', $subtask2, PDO::PARAM_STR);
        $stmt->bindValue(':is_complete', 'false', PDO::PARAM_STR);
        $stmt->execute();
    }
    if ($subtask3 != "") {
        $stmt = $db->prepare('INSERT into public.subtask(user_id, task_id, task_text, is_complete) 
            VALUES (:user_id, :task_id, :task_text, :is_complete);');
        $stmt->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
        $stmt->bindValue(':task_id', $task_id, PDO::PARAM_STR);
        $stmt->bindValue(':task_text', $subtask3, PDO::PARAM_STR);
        $stmt->bindValue(':is_complete', 'false', PDO::PARAM_STR);
        $stmt->execute();
    }
    if ($subtask4 != "") {
        $stmt = $db->prepare('INSERT into public.subtask(user_id, task_id, task_text, is_complete) 
            VALUES (:user_id, :task_id, :task_text, :is_complete);');
        $stmt->bindValue(':user_id', $_SESSION["user_id"], PDO::PARAM_STR);
        $stmt->bindValue(':task_id', $task_id, PDO::PARAM_STR);
        $stmt->bindValue(':task_text', $subtask4, PDO::PARAM_STR);
        $stmt->bindValue(':is_complete', 'false', PDO::PARAM_STR);
        $stmt->execute();
    }

    //redirect the page to TaskMe.php
    header("Location: TaskMe.php");
    die();
?>