<?php

session_start();

if(isset($_SESSION['admin']) && $_SESSION['admin']) {
    header("Location: start");
    die();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Boule-Turnier Login</title>
        <link href="styles/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <form action="login_check.php" method="post">
            <label for="password">Passwort</label>
            <input type="password" name="password" required>
            <button type="submit">Einloggen</button>
        </form>

    </body>
</html>
