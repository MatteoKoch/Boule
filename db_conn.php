<?php

//$sname = "db5005567525.hosting-data.io";
//$uname = "dbu985699";
//$password = "Mamemo1234567";

//$db_name = "dbs4680886";

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