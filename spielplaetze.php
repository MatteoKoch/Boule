<?php

session_start();

if(!isset($_SESSION['admin'])) {
    header("Location: login");
    die();
}

if(isset($_POST['spielplatz']) && isset($_SESSION['admin'])) {
    setcookie("plaetze", $_POST['spielplatz'], strtotime( '+30 days' ));
    header("Location: teams-erstellen");
    die();
}

require_once "lang/de.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Spielplatzeingabe</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php require_once "header.php"; ?>

<form action="" method="post">
    <label for="spielplatz"><?= $lang['SPIELPLATZ'] ?></label>
    <input type="number" name="spielplatz" value="<?= isset($_COOKIE['plaetze'])?$_COOKIE['plaetze']:"" ?>" placeholder="<?= $lang['SPIELPLATZ_PLACEHOLDER'] ?>" required>
    <button type="submit"><?= $lang['SPIELPLATZ_OK'] ?></button>
</form>

</body>
</html>
