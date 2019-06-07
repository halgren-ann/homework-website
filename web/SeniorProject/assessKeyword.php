<?php

/*This service accepts a keyword and then If the keyword is found in the databse:
    - The player is assigned a number (2-4) and added to that game instance
    If the keyword is not found in the database:
        - A new instance of the game is created and this player is made the game host
    In both cases, the player's player_number is returned to them (a number 1-4, with 1 indicating that the player is the game host)
*/
/*$inputText = json_decode(file_get_contents('php://input'));*/
$keyword = "happy";/*$inputText->keyword;*/
$display_name = "The Man";/*$inputText->display_name;*/
include 'dbConnect.php';
session_start();

$stmt = $db->prepare('SELECT * FROM public.game WHERE keyword =:keyword;');
$stmt->execute(array(':keyword' => $keyword));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($rows[0]) {
    //Then this keyword already exists in the database, and the player is joining that game
    if ($rows[0].num_players < 4) {
        $num_players = $rows[0].num_players + 1;
        //Update the public.game table to reflect the number of players now
        $stmt = $db->prepare('UPDATE public.game SET num_players = :num_players WHERE keyword =:keyword;');
        $stmt->bindValue(':num_players', $num_players, PDO::PARAM_STR);
        $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        //Add the player to the database public.player table
        $stmt = $db->prepare('INSERT into public.player(game_id, player_number, display_name, is_turn, score) 
            VALUES (:game_id, :player_number, :display_name, :is_turn, :score) RETURNING player_id;');
        $stmt->bindValue(':game_id',$rows[0].game_id, PDO::PARAM_STR);
        $stmt->bindValue(':player_number', $rows[0].num_players, PDO::PARAM_STR);
        $stmt->bindValue(':display_name', $display_name, PDO::PARAM_STR);
        $stmt->bindValue(':is_turn', 'false', PDO::PARAM_STR);
        $stmt->bindValue(':score', '0', PDO::PARAM_STR);
        $stmt->execute();
        //$result = $stmt->get_result();
        //$outp = $result->fetch_all(PDO::FETCH_ASSOC);
        //$player_id = $outp[0].player_id;
        //Return the player number and the player id with JSON format
        $player_number = $rows[0].num_players;
        echo '{"player_id":' . '"1"' . ', "player_number":' . $player_number . '}';
    }
    else {
        //There are already 4 players, return "error"
        echo '{"player_id":' . '"error"' . ', "player_number":' . '"error"' . '}';
    }
}
else {
    //Then this keyword was not in the database and this player becomes the host (player_number = 1)
    //Add a new game instance row to the public.game table
    $stmt = $db->prepare('INSERT into public.game(keyword, num_players, game_obsolete) 
        VALUES (:keyword, :num_players, :game_obsolete) RETURNING game_id;');
    $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
    $stmt->bindValue(':num_players', "1", PDO::PARAM_STR);
    $stmt->bindValue(':game_obsolete', 'false', PDO::PARAM_STR);
    $game_id = $stmt->execute();
    //TODO Add the player to the database public.player table
    $stmt = $db->prepare('INSERT into public.player(game_id, player_number, display_name, is_turn, score) 
        VALUES (:game_id, :player_number, :display_name, :is_turn, :score) RETURNING player_id;');
    $stmt->bindValue(':game_id', $game_id, PDO::PARAM_STR);
    $stmt->bindValue(':player_number', "1", PDO::PARAM_STR);
    $stmt->bindValue(':display_name', $display_name, PDO::PARAM_STR);
    $stmt->bindValue(':is_turn', 'true', PDO::PARAM_STR);
    $stmt->bindValue(':score', '0', PDO::PARAM_STR);
    /*$player_id = */$stmt->execute();
    //Return the information in JSON format
    echo '{"player_id":' . '"1"' . ', "player_number":' . '"1"' . '}';
}

?>