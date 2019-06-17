<?php
/*This service accepts the player's id and game id and then checks to see if there are
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

//First, grab what I need from the update_manager table
$stmt = $db->prepare('SELECT * FROM public.update_manager WHERE game_id = :game_id AND player_id = :player_id AND seen = :seen;');
$stmt->execute(array(':game_id' => $game_id, ':player_id' => $player_id, ':seen' => 'false'));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC); //Could be zero, one, or many rows returned
//Then, mark all those entries as "seen"
$stmt = $db->prepare('UPDATE public.update_manager SET seen = :seen WHERE game_id = :game_id AND player_id = :player_id;');
$stmt->execute(array(':seen' => 'true', ':game_id' => $game_id, ':player_id' => $player_id));

$JSONstr = ""; //this collects all the information to be returned to te user

for ($i=0; $i < count($rows); $i++) {
    if($JSONstr == "") {
        $JSONstr = $JSONstr . '[';//this is the first update, so begin the JSON array
    }
    else {
        $JSONstr = $JSONstr . ',';//this is NOT the first update, so add a comma between elements
    }

    $what = json_decode($rows[$i]["what"], false); //get the JSON stored in "what" column
    $desc = $what->desc;
    $info = $what->info;

    //TODO finish filling in these statements
    if($desc == 'new_player') {
        //Get the new player's info
        $stmt = $db->prepare('SELECT * FROM public.player WHERE player_id = :player_id;');
        $stmt->execute(array(':player_id' => $info));
        $new_playerRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($new_playerRow[0]["is_turn"] == true) {
            $is_turn = "true";
        }
        else {
            $is_turn = "false";
        }

        $JSONstr = $JSONstr . '{ "desc": "new_player", "player_id": ' . $new_playerRow[0]["player_id"] . ', "player_number": ' . $new_playerRow[0]["player_number"] . ', "display_name": "' . $new_playerRow[0]["display_name"] . '", "is_turn": ' . $is_turn . ', "score": ' . $new_playerRow[0]["score"] . '}';
    }
    else if($desc == 'start_state') {
        //Get the cards from the start_state table
        $stmt = $db->prepare('SELECT * FROM public.start_state WHERE game_id = :game_id ORDER BY position_in_deck;');
        $stmt->execute(array(':game_id' => $info));
        $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $JSONstr = $JSONstr . '{ "desc": "start_state", "cards": [';
        for($i=0; $i<count($cards); $i++) {
            if($i != 0) {
                $JSONstr = $JSONstr . ", ";
            }
            $JSONstr = $JSONstr . '"' . $cards[$i]["card_id"] . '"';
        }
        //Grab the number of players in this game
        $stmt = $db->prepare('SELECT * FROM public.game WHERE game_id = :game_id;');
        $stmt->execute(array(':game_id' => $info));
        $num = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $JSONstr = $JSONstr . '], "num_players": ' . $num[0]["num_players"] . '}';
    }
    else if($desc == 'move') {
        echo 'move';
    }
    else {
        echo 'error';
    }
}

//Return all the information to the user
if($JSONstr == "") {
    echo 'no_updates';
}
else {
    $JSONstr = $JSONstr . ']'; //finish the JSON array
    echo $JSONstr;
}
?>