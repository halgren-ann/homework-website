<?php
//Coding complete
/*This service accepts the array of shuffled cards from the host player, and stores it in 
    the start_state table in the database
*/

header("Content-Type: application/json; charset=UTF-8");
$inputText = json_decode(file_get_contents('php://input'), false);
$cardArray = json_decode($inputText->cardArray, false);
$game_id = $inputText->game_id;
include 'dbConnect.php';
session_start();

echo "Count of cardArray: " . count($cardArray) . " cardArray: " . $cardArray;

for ($i=0; $i<count($cardArray); $i++) {
    //Add each card to the database
    $stmt = $db->prepare('INSERT into public.start_state(game_id, card_id, position_in_deck) 
        VALUES (:game_id, :card_id, :position_in_deck);');
    $stmt->execute(array(':game_id' => $game_id, ':card_id' => $cardArray[$i]["id"], ':position_in_deck' => $i));
    echo "Row inserted into public.start_state";
}


?>