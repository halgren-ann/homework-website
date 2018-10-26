<?php
    include 'dbConnect.php';
    session_start();

    $stmt = $db->prepare('DELETE FROM public.subtask WHERE is_complete = :is_complete AND user_id = :user_id');
    $stmt->bindValue(':is_complete', true);
    $stmt->bindValue(':user_id', $_SESSION["user_id"]);
    $stmt->execute();
    
    //If it's a main task that was deleted, have to delete all the subtasks first
    $stmt = $db->prepare('SELECT * FROM public.task WHERE user_id = :user_id AND is_complete = :is_complete;');
    $stmt->execute(array(':user_id' => $_SESSION["user_id"], ':is_complete' => true));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($rows as $row) {
        $task_id = $row["id"];
        $stmt = $db->prepare('DELETE public.subtask WHERE task_id = :task_id AND user_id = :user_id');
        $stmt->bindValue(':task_id', $task_id);
        $stmt->bindValue(':user_id', $_SESSION["user_id"]);
        $stmt->execute();
    }
    
    $stmt = $db->prepare('DELETE FROM public.task WHERE is_complete = :is_complete AND user_id = :user_id');
    $stmt->bindValue(':is_complete', true);
    $stmt->bindValue(':user_id', $_SESSION["user_id"]);
    $stmt->execute();
?>