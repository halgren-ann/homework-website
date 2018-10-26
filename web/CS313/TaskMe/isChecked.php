<?php
    $task_text = $HTTP_RAW_POST_DATA;
    include 'dbConnect.php';

    $stmt = $db->prepare('UPDATE public.subtask SET is_complete = :is_complete WHERE task_text = :task_text');
    $stmt->bindValue(':is_complete', true);
    $stmt->bindValue(':task_text', $task_text, PDO::PARAM_STR);
    $stmt->execute();
?>