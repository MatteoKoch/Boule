<?php

session_start();

require_once "db_conn.php";

if(!isset($_POST['points'])) {
    $sql_teams = $conn->prepare("SELECT * FROM teams");
    $sql_teams->execute();
    $res_teams = $sql_teams->get_result();
    $sql_teams->close();

    $teams = $res_teams->fetch_all();
    shuffle($teams);
} else {
    $teams = $_POST['points'];
}

$sql_games = $conn->prepare("INSERT INTO spiele(team_1_id, team_2_id) VALUES(?, ?)");
for($i = 0; $i < count($teams); $i+=2) {
    $sql_games->bind_param("ii", $teams[$i][0], $teams[$i+1][0]);
    $sql_games->execute();
}
$sql_games->close();

$_SESSION['runde']++;

header("Location: aufstellung");
die();

?>