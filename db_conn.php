<?php

$sname = "db5005567525.hosting-data.io";
$uname = "dbu985699";
$password = "Mamemo1234567";

$db_name = "dbs4680886";


$conn = mysqli_connect($sname, $uname, $password, $db_name);

    if(!$conn) {
        echo "Verbindung fehlgeschlagen!";
        exit();
    }

?>