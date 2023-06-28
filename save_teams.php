<?php

session_start();

if(!isset($_SESSION['admin'])) {
    header("Location: login");
    die();
}

if(isset($_POST['team']) && isset($_POST['member'])) {

    require_once "db_conn.php";

    $teams = $_POST['team'];
    $members = $_POST['member'];

    $sql_team = $conn->prepare("INSERT INTO teams(name) VALUES(?)");
    $sql_member = $conn->prepare("INSERT INTO teams_mitglieder(teams_id, mitglied) VALUES(?, ?)");
    for ($i = 0; $i < count($teams); $i++) {
        $team_name = htmlentities($teams[$i]);
        $sql_team->bind_param("s", $team_name);
        $sql_team->execute();
        $insert_id = $sql_team->insert_id;

        for ($j = 0; $j < count($members[$i]); $j++) {
            $member_name = htmlentities($members[$i][$j]);
            $sql_member->bind_param("is", $insert_id, $member_name);
            $sql_member->execute();
        }
    }
    $sql_member->close();
    $sql_team->close();

}

header("Location: aufstellung.php");
die();

?>