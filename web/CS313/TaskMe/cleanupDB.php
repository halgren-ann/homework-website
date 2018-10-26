<?php
    include 'dbConnect.php';

    $stmt = $db->prepare('DELETE FROM public.task WHERE is_complete = :is_complete');
    $stmt->execute(array(':is_complete' => true));

    $stmt = $db->prepare('DELETE FROM public.subtask WHERE is_complete = :is_complete');
    $stmt->execute(array(':is_complete' => true));
?>