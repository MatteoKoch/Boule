<?php

session_start();

if(!isset($_SESSION['admin'])) {
    header("Location: login");
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

<form action="save_teams.php" method="post">
    <div class="form-wrapper">
        <div class="team-block">
            <label for="teamname">Name des Teams</label>
            <input type="text" name="team[]" placeholder="Teamname" required>
            <label>Mitglieder</label>
            <div class="team-members"></div>
        </div>
    </div>
    <button type="button" onclick="addTeam()">+ Team hinzuf&uuml;gen</button>
    <button type="submit">Speichern und weiter zur Aufstellung</button>
</form>

</body>
</html>