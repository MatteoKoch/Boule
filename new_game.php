<?php

session_start();

if(!isset($_SESSION['admin'])) {
    header("Location: login");
    die();
}

require_once "db_conn.php";

$sql_teams = "DELETE FROM teams";
$sql_spiele = "DELETE FROM spiele";
mysqli_query($conn, $sql_teams);
mysqli_query($conn, $sql_spiele);

$_SESSION['runde'] = 0;

header("Location: login");
die();

?>