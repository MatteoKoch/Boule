<?php

session_start();

if(!isset($_SESSION['admin'])) {
    header("Location: login");
    die();
}

require_once "db_conn.php";

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Aufstellung</title>
        <link href="styles/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <table>
            <thead>
                <tr><td colspan="2" style="text-align: center; font-weight: bold;">Aufstellung</td></tr>
            </thead>
            <tbody>
                <?php

                $sql_teams = $conn->prepare("SELECT * FROM teams");
                $sql_teams->execute();
                $res_teams = $sql_teams->get_result();
                $sql_teams->close();

                $teams = $res_teams->fetch_all();
                shuffle($teams);

                $sql_members = $conn->prepare("SELECT * FROM teams_mitglieder WHERE teams_id = ?");
                for($i = 0; $i < count($teams); $i+=2) {
                    echo "<tr>\n";
                        echo "<td>{$teams[$i][1]}</td>\n";
                        echo "<td>{$teams[$i+1][1]}</td>\n";
                    echo "</tr>\n";
                }
                $sql_members->close();

                ?>
            </tbody>
        </table>

    </body>
</html>