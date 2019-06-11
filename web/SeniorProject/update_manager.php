<?php

/*This service accepts the player's id and game id and then check to see if there are
    updates to be seen for that player in the update_manager table in the database.
    If there are updates, this file also goes and gets the updates, then returns the 
    information, along with what type of update it is, to the user.
*/

header("Content-Type: application/json; charset=UTF-8");
$inputText = json_decode(file_get_contents('php://input'), false);
$game_id = $inputText->game_id;
$player_id = $inputText->player_id;
include 'dbConnect.php';
session_start();

$stmt = $db->prepare('SELECT * FROM public.update_manager WHERE game_id = :game_id AND player_id = :player_id AND seen = :seen;');
$stmt->execute(array(':game_id' => $game_id, ':player_id' => $player_id, ':seen' => 'false'));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC); //Could be zero, one, or many rows returned

for ($i=0; $i < count($rows); $i++) {
    $what = json_decode($rows[$i]["what"], false); //get the JSON stored in "what" column
    $desc = $what->desc;
    $info = $what->info;

    //TODO finish filling in these statements
    if($desc == 'new_player') {
        echo 'new_player';
    }
    else if($desc == 'start_state') {
        echo 'start_state';
    }
    else if($desc == 'move') {
        echo 'move';
    }
    else {
        echo 'error';
    }
}

echo 'done';
?>