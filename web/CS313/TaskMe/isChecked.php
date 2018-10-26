<?php
    $task_text = $HTTP_RAW_POST_DATA;
    include 'dbConnect.php';

    $stmt = $db->prepare('UPDATE public.subtask SET is_complete = :is_complete WHERE task_text = :task_text');
    $stmt->execute(array(':task_text' => $task_text, ':is_complete' => 'true'));
?>