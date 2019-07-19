<?php
//Coding complete
/*This service accepts the array of shuffled cards from the host player, and stores it in 
    the start_state table in the database
*/

header("Content-Type: application/json; charset=UTF-8");
$inputText = json_decode(file_get_contents('php://input'), false);
$cardArray = $inputText->cardArray;
$game_id = $inputText->game_id;
include 'dbConnect.php';
session_start();

//First, delete any previous decks from this game, if this is a deck restart
$stmt = $db->prepare('DELETE FROM public.start_state WHERE game_id = :game_id;');
$stmt->execute(array(':game_id' => $game_id));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//Insert each card in the deck into the public.start_state table
for ($i=0; $i<count($cardArray); $i++) {
    //Add each card to the database
    $stmt = $db->prepare('INSERT into public.start_state(game_id, card_id, position_in_deck) 
        VALUES (:game_id, :card_id, :position_in_deck);');
    $stmt->execute(array(':game_id' => $game_id, ':card_id' => $cardArray[$i]->id, ':position_in_deck' => $i));
}
//tell the update_manager that each player now needs to pull from the start_state table
//first, grab the player_id of each player in this game
$stmt = $db->prepare('SELECT * FROM public.player WHERE game_id = :game_id;');
$stmt->execute(array(':game_id' => $game_id));
$playerRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//then insert the rows
for ($i=0; $i<count($playerRows); $i++) {
    $JSONstr = '{ "desc": "start_state", "info": ' . $game_id . '}';
    $stmt = $db->prepare('INSERT into public.update_manager(game_id, player_id, seen, what) 
        VALUES (:game_id, :player_id, :seen, :what);');
    $stmt->execute(array(':game_id' => $game_id, ':player_id' => $playerRows[$i]["player_id"], ':seen' => 'false', ':what' => $JSONstr));
    $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>