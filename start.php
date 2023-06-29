<?php

session_start();

if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    die();
}

require_once "lang/de.php";

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Boule-Turnier Start</title>
        <link href="styles/style.css" rel="stylesheet" type="text/css">
        <script src="scripts/teams.js" defer></script>
    </head>
    <body>

        <div style="display: grid; gap: 20px;">
            <a href="spielplaetze"><?= $lang['START_NEUES_SPIEL'] ?></a>
            <a><?= $lang['START_ALLE_TURNIERE'] ?></a>
        </div>


    </body>
</html>