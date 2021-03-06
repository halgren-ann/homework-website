<?php
    $task_text = file_get_contents('php://input');
    include 'dbConnect.php';
    session_start();

    $stmt = $db->prepare('UPDATE public.task SET is_complete = :is_complete WHERE task_text = :task_text AND user_id = :user_id');
    $stmt->bindValue(':is_complete', true);
    $stmt->bindValue(':task_text', $task_text, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $_SESSION["user_id"]);
    $stmt->execute();

    $stmt = $db->prepare('UPDATE public.subtask SET is_complete = :is_complete WHERE task_text = :task_text AND user_id = :user_id');
    $stmt->bindValue(':is_complete', true);
    $stmt->bindValue(':task_text', $task_text, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $_SESSION["user_id"]);
    $stmt->execute();
?>