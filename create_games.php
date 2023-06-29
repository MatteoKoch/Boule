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

$plaetze = range(1, isset($_COOKIE['plaetze'])?$_COOKIE['plaetze']:count($teams));
shuffle($plaetze);

$sql_games = $conn->prepare("INSERT INTO spiele(team_1_id, team_2_id, spielplatz) VALUES(?, ?, ?)");
$sql_games_backup = $conn->prepare("INSERT INTO spiele_backup(id, team_1_id, team_2_id, spielplatz) VALUES(?, ?, ?, ?)");
for($i = 0; $i < count($teams); $i+=2) {
    $sql_games->bind_param("iii", $teams[$i][0], $teams[$i+1][0], $plaetze[$i]);
    $sql_games->execute();
    $insert_id = $sql_games->insert_id;

    $sql_games_backup->bind_param("iiii", $insert_id, $teams[$i][0], $teams[$i+1][0], $plaetze[$i]);
    $sql_games_backup->execute();
}
$sql_games_backup->close();
$sql_games->close();

$_SESSION['runde']++;

header("Location: spiel");
die();

?>