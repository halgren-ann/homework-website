<?php

/*This service accepts a keyword and then If the keyword is found in the databse:
    - The player is assigned a number (2-4) and added to that game instance
    If the keyword is not found in the database:
        - A new instance of the game is created and this player is made the game host
    In both cases, the player's player_number and player_id are returned to them (the player_number is a number 1-4, with 1 indicating that the player is the game host)
*/

header("Content-Type: application/json; charset=UTF-8");
$inputText = json_decode(file_get_contents('php://input'), false);
$keyword = $inputText->keyword;
$display_name = $inputText->display_name;
include 'dbConnect.php';
session_start();

$stmt = $db->prepare('SELECT * FROM public.game WHERE keyword =:keyword;');
$stmt->execute(array(':keyword' => $keyword));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($rows[0]) {
    //Then this keyword already exists in the database, and the player is joining that game
    if ($rows[0]["num_players"] < 4) {
        //Update the public.game table to reflect the number of players now
        $num_players = $rows[0]["num_players"] + 1;
        $stmt = $db->prepare('UPDATE public.game SET num_players = :num_players WHERE keyword = :keyword;');
        $stmt->execute(array(':num_players' => $num_players, ':keyword' => $keyword));
        $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Add the player to the database public.player table
        $stmt = $db->prepare('INSERT into public.player(player_id, game_id, player_number, display_name, is_turn, score) 
            VALUES (:game_id, :player_number, :display_name, :is_turn, :score);');
        $stmt->execute(array(':game_id' => $rows[0]["game_id"], ':player_number' => $rows[0]["num_players"], ':display_name' => $display_name, ':is_turn' => 'false', ':score' => '0'));
        $stmt->fetchAll(PDO::FETCH_ASSOC);
        //Collect the player's id
        $stmt = $db->prepare('SELECT * FROM public.player WHERE game_id =:game_id AND player_number = :player_number;');
        $stmt->execute(array(':game_id' => $rows[0]["game_id"], ':player_number' => $num_players));
        $PlayerRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //Return the information in JSON format
        echo '{"player_id":' . $playerRows[0]["player_id"] . ', "player_number":' . $num_players . '}';
    }
    else {
        //There are already 4 players, return "error"
        //Return the information in JSON format
        echo '{"player_id":' . '"error"' . ', "player_number":' . '"error"' . '}';
    }
}
else {
    //Then this keyword was not in the database and this player becomes the host (player_number = 1)
    //Add a new game instance row to the public.game table
    //Add the player to the database public.player table
    //Return the information in JSON format
    echo '{"player_id":' . '"Is"' . ', "player_number":' . '"Host"' . '}';
}

?>