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

echo '{"player_id":' . '"error"' . ', "player_number":' . '"error"' . '}';

?>