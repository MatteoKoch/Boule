<?php

session_start();

if(isset($_SESSION['admin']) && isset($_POST['team'])) {

    require_once "db_conn.php";

    $points = $_POST['team'];

    $sql_game = $conn->prepare("UPDATE spiele SET team_1_punkte = ?, team_2_punkte = ? WHERE id = ? AND team_1_id = ? AND team_2_id = ?");
    foreach($points as $game_id => $value) {
        $keys = array_keys($value);
        $sql_game->bind_param("iiiii", $value[$keys[0]], $value[$keys[1]], $game_id, $keys[0], $keys[1]);
        $sql_game->execute();
    }
    $sql_game->close();

    die();

}


?>