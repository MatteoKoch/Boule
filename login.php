<?php

session_start();

if(isset($_SESSION['admin']) && $_SESSION['admin']) {
    header("Location: start");
    die();
}

require_once "lang/de.php";

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Boule-Turnier Login</title>
        <link href="styles/style.css" rel="stylesheet" type="text/css">
    </head>
    <body style="background: #b6b6ba;">

        <form action="login_check.php" method="post">
            <label for="password"><?= $lang['LOGIN_PASSWORT'] ?></label>
            <input type="password" name="password" required>
            <button type="submit"><?= $lang['LOGIN_PASSWORT_OK'] ?></button>
        </form>

    </body>
</html>
