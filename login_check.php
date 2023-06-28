<?php

session_start();

if(isset($_POST['password']) && $_POST['password'] === "Hefeweizen") {
    $_SESSION['admin'] = true;
    header("Location: start");
    die();
}

header("Location: login");
die();

?>