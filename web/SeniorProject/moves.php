<?php
/*This service accepts the player's information about the move they just made, and
    stores the information in the public.moves table in the database. Then the 
    public.update_manager table is updated with the move_id so that it knows a new
    move has been made. Nothing is returned to the user from this service.
*/

header("Content-Type: application/json; charset=UTF-8");
$inputText = json_decode(file_get_contents('php://input'), false);
$game_id = $inputText->game_id;
$player_id = $inputText->player_id;
$card_id = $inputText->card_id; //This is the html id for the div representing this card
$start_position = $inputText->start_position; //This is the number (1-7) out of the user's hand that was played
$end_position = $inputText->end_position; //this is the array name ("" not allowed) of where the card was played to
include 'dbConnect.php';
session_start();
echo 'checkpoint A values: game_id is ' . $game_id . 'player_id is ' . $player_id . ' card_id is ' . $card_id . ' start_position is ' . $start_position . ' end_position is ' . $end_position;

//Insert the new move into the public.moves table
$stmt = $db->prepare('INSERT into public.moves(game_id, player_id, card_id, start_position, end_position) 
    VALUES (:game_id, :player_id, :card_id, :start_position, :end_position);');
$stmt->execute(array(':game_id' => $game_id, ':player_id' => $player_id, ':card_id' => $card_id, ':start_position' => $start_position, ':end_position' => $end_position));

//Now select what I just inserted to get the move_id
$stmt = $db->prepare('SELECT * FROM public.moves WHERE game_id = :game_id AND player_id = :player_id AND card_id = :card_id;');
$stmt->execute(array(':game_id' => $game_id, ':player_id' => $player_id, ':card_id' => $card_id));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$move_id = $rows[0]["move_id"];

//Next, Insert an update with this move_id into the public.update_manager table
$JSONstr = '{"desc": "move", "info": ' . $move_id . '}';

$stmt = $db->prepare('SELECT * FROM public.player WHERE game_id = :game_id;');
$stmt->execute(array(':game_id' => $game_id));
$player_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i<count($rows); $i++) {
    //The player this came from does not need to be updated
    if ($rows[$i]["player_id"] != $player_id) {
        $stmt = $db->prepare('INSERT into public.update_manager(game_id, player_id, seen, what) 
            VALUES (:game_id, :player_id, :seen, :what);');
        $stmt->execute(array(':game_id' => $game_id, ':player_id' => $rows[$i]["player_id"], ':seen' => 'false', 'what' => $JSONstr));
    }
}
?>