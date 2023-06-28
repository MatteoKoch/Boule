<?php

    $sname = "localhost";
    $uname = "root";
    $password = "";

    $db_name = "boule_turnier";

    $conn = mysqli_connect($sname, $uname, $password, $db_name);

    if(!$conn) {
        echo "Verbindung fehlgeschlagen!";
        exit();
    }

?>