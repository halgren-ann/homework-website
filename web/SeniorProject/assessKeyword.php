<?php

/*This service accepts a keyword and then If the keyword is found in the databse:
    - The player is assigned a number (2-4) and added to that game instance
    If the keyword is not found in the database:
        - A new instance of the game is created and this player is made the game host
    In both cases, the player's player_number is returned to them (a number 1-4, with 1 indicating that the player is the game host)
*/
$keyword = file_get_contents('php://input');
include 'dbConnect.php';
session_start();

$stmt = $db->prepare('SELECT * FROM public.game WHERE keyword = :keyword');
$stmt->execute(array(':keyword' => $keyword));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($rows[0]) {
    //Then this keyword already exists in the database, and the player is joining that game
    if ($rows[0].num_players < 4) {
        //TODO Update the public.game table to reflect the number of players now
        //TODO Add the player to the database public.player table
        $player_number = $rows[0].num_players;
        echo $player_number;
    }
    else {
        //There are already 4 players, return "error"
        echo "error";
    }
}
else {
    //Then this keyword was not in the database and this player becomes the host (player_number = 1)
    //TODO Add a new game instance row to the public.game table
    //TODO Add the player to the database public.player table
    echo "1";
}

/*
$stmt = $db->prepare('UPDATE public.subtask SET is_complete = :is_complete WHERE task_text = :task_text AND user_id = :user_id');
$stmt->bindValue(':is_complete', true);
$stmt->bindValue(':task_text', $task_text, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $_SESSION["user_id"]);
$stmt->execute();
*/
?>