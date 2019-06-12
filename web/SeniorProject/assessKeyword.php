<?php
//TODO add funtionality for update_manager to get a new entry when a new player is added to the game (both ways)
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

        //Grab the game_id
        $stmt = $db->prepare('SELECT * FROM public.game WHERE keyword =:keyword;');
        $stmt->execute(array(':keyword' => $keyword));
        $gameRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $game_id = $gameRows[0]["game_id"];

        //Add the player to the database public.player table
        $stmt = $db->prepare('INSERT into public.player(game_id, player_number, display_name, is_turn, score) 
            VALUES (:game_id, :player_number, :display_name, :is_turn, :score);');
        $stmt->execute(array(':game_id' => $rows[0]["game_id"], ':player_number' => $num_players, ':display_name' => $display_name, ':is_turn' => 'false', ':score' => '0'));
        $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Grab the player_id
        $stmt = $db->prepare('SELECT * FROM public.player WHERE game_id = :game_id AND player_number = :player_number;');
        $stmt->execute(array(':game_id' => $rows[0]["game_id"], ':player_number' => $rows[0]["num_players"]));
        $newRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /*
        Tell update_manager table that:
            - This new player needs to know about all the already existing players
            - All the already existing players need to know about this player
        */
        for($i=1; $i<$num_players; $i++) {
            //Grab the player_id of other players
            $stmt = $db->prepare('SELECT * FROM public.player WHERE game_id = :game_id AND player_number = :player_number;');
            $stmt->execute(array(':game_id' => $game_id, ':player_number' => $i));
            $originalPlayer = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //Insert row into update_manager to update this player about the original player
            $JSONstr = '{ "desc": "new_player", "player_id": ' . $originalPlayer[0]["player_id"] . '}';
            $stmt = $db->prepare('INSERT into public.update_manager(game_id, player_id, seen, what) 
                VALUES (:game_id, :player_id, :seen, :what);');
            $stmt->execute(array(':game_id' => $game_id, ':player_id' => $newRows[0]["player_id"], ':seen' => 'false', ':what' => $JSONstr));
            $stmt->fetchAll(PDO::FETCH_ASSOC);
            //Insert row into update_manager to update the original player about this player
            $JSONstr = '{ "desc": "new_player", "player_id": ' . $newRows[0]["player_id"] . '}';
            $stmt = $db->prepare('INSERT into public.update_manager(game_id, player_id, seen, what) 
                VALUES (:game_id, :player_id, :seen, :what);');
            $stmt->execute(array(':game_id' => $game_id, ':player_id' => $originalPlayer[0]["player_id"], ':seen' => 'false', ':what' => $JSONstr));
            $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //Return the information about the current player in JSON format
        echo '{"player_id":' . $newRows[0]["player_id"] . ', "player_number":' . $num_players . ', "game_id":' . $game_id . '}';
    }
    else {
        //There are already 4 players, return "error"
        //Return the information in JSON format
        echo '{"player_id":' . '"error"' . ', "player_number":' . '"error"' . ', "game_id":' . '"error"' . '}';
    }
}
else {
    //Then this keyword was not in the database and this player becomes the host (player_number = 1)
    //Add a new game instance row to the public.game table
    $stmt = $db->prepare('INSERT into public.game(keyword, num_players, game_obsolete) 
        VALUES (:keyword, :num_players, :game_obsolete);');
    $stmt->execute(array(':keyword' => $keyword, ':num_players' => '1', ':game_obsolete' => 'false'));
    $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Grab the game_id
    $stmt = $db->prepare('SELECT * FROM public.game WHERE keyword =:keyword;');
    $stmt->execute(array(':keyword' => $keyword));
    $gameRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $game_id = $gameRows[0]["game_id"];

    //Add the player to the database public.player table
    $stmt = $db->prepare('INSERT into public.player(game_id, player_number, display_name, is_turn, score) 
        VALUES (:game_id, :player_number, :display_name, :is_turn, :score);');
    $stmt->execute(array(':game_id' => $game_id, ':player_number' => '1', ':display_name' => $display_name, ':is_turn' => 'true', ':score' => '0'));
    $stmt->fetchAll(PDO::FETCH_ASSOC);

     //Grab the player_id
     $stmt = $db->prepare('SELECT * FROM public.player WHERE game_id = :game_id AND player_number = :player_number;');
     $stmt->execute(array(':game_id' => $game_id, ':player_number' => '1'));
     $newRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Return the information in JSON format
    echo '{"player_id":' . $newRows[0]["player_id"] . ', "player_number":' . '"1"' . ', "game_id":' . $game_id . '}';
}

?>