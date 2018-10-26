<?php
    $task_text = file_get_contents('php://input');
    include 'dbConnect.php';

    $stmt = $db->prepare('UPDATE public.subtask SET is_complete = :is_complete WHERE task_text = :task_text');
    $stmt->bindValue(':is_complete', true);
    $stmt->bindValue(':task_text', $task_text, PDO::PARAM_STR);
    $stmt->execute();
?>