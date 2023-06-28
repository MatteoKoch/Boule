<?php

session_start();

if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    die();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Teams erstellen</title>
        <link href="styles/style.css" rel="stylesheet" type="text/css">
        <script src="scripts/teams.js" defer></script>
    </head>
    <body>

        <a href="teams-erstellen.php">Neues Spiel</a>

    </body>
</html>