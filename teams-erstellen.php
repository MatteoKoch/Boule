<?php

session_start();

if(!isset($_SESSION['admin'])) {
    header("Location: login");
    die();
}

require_once "lang/de.php";

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Teams erstellen</title>
        <link href="styles/style.css" rel="stylesheet" type="text/css">
        <script src="scripts/teams.js" defer></script>
    </head>
    <body style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 40px;">

        <?php require_once "header.php"; ?>

        <div id="teams">
            <?php require_once "zeige-teams.php"; ?>
        </div>

        <form>
            <div class="form-wrapper">
                <div class="team-block">
                    <label for="teamname"><?= $lang['TEAMS_ERSTELLEN_NAME'] ?></label>
                    <input type="text" name="team[]" placeholder="<?= $lang['TEAMS_ERSTELLEN_TEAM_PLACEHOLDER'] ?>" required>
                    <label><?= $lang['TEAMS_ERSTELLEN_MEMBERS'] ?></label>
                    <div class="team-members"></div>
                </div>
            </div>
            <button type="button" onclick="addTeam()"><?= $lang['TEAMS_ERSTELLEN_SPEICHERN'] ?></button>
            <a href="create_games.php"><?= $lang['TEAMS_ERSTELLEN_WEITER'] ?></a>

        </form>

    </body>
</html>