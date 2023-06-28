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
        <title>Spielstand</title>
        <link href="styles/style.css" rel="stylesheet" type="text/css">
        <script src="scripts/spiel.js" defer></script>
    </head>
    <body>

        <div style="display: grid; gap: 50px;">
            <table class="aufstellung">
                <thead>
                <tr><td colspan="4" style="text-align: center; font-weight: bold;">Spielstand</td></tr>
                </thead>
                <tbody>
                <?php

                $sql_number_teams = $conn->prepare("SELECT count(id) as anz FROM teams");
                $sql_number_teams->execute();
                $res_number_teams = $sql_number_teams->get_result();
                $number_of_teams = intval($res_number_teams->fetch_assoc()['anz'])/2;
                $sql_number_teams->close();

                $sql_teams = $conn->prepare("SELECT * FROM spiele ORDER BY id DESC LIMIT ?");
                $sql_teams->bind_param("i", $number_of_teams);
                $sql_teams->execute();
                $res_teams = $sql_teams->get_result();
                $sql_teams->close();

                $teams = $res_teams->fetch_all();

                $sql_team_names = $conn->prepare("SELECT * FROM teams WHERE id = ?");
                $sql_members = $conn->prepare("SELECT * FROM teams_mitglieder WHERE teams_id = ?");
                for($i = 0; $i < count($teams); $i++) {
                    echo "<tr data-id='{$teams[$i][0]}'>\n";

                        echo "<td>\n";
                            $sql_team_names->bind_param("i", $teams[$i][1]);
                            $sql_team_names->execute();
                            $res_team_names = $sql_team_names->get_result();
                            echo "{$res_team_names->fetch_assoc()['name']}\n";
                            echo "<span style='display: flex; gap: 10px; align-items: end;'>\n";
                            $sql_members->bind_param("i", $teams[$i][1]);
                            $sql_members->execute();
                            $res_members = $sql_members->get_result();
                            while($row = $res_members->fetch_assoc()) {
                                echo "<span style='color: #444; font-size: 20px;'>{$row['mitglied']}</span>\n";
                            }
                            echo "</span>\n";
                        echo "</td>\n";

                        echo "<td style='width: 50px; padding: 0; text-align: center; font-weight: bold;' id='team[{$teams[$i][0]}][{$teams[$i][1]}]' contenteditable='true'>{$teams[$i][2]}</td>\n";

                        echo "<td>\n";
                            $sql_team_names->bind_param("i", $teams[$i][3]);
                            $sql_team_names->execute();
                            $res_team_names = $sql_team_names->get_result();
                            echo "{$res_team_names->fetch_assoc()['name']}\n";
                            echo "<span style='display: flex; gap: 10px; align-items: end;'>\n";
                            $sql_members->bind_param("i", $teams[$i][3]);
                            $sql_members->execute();
                            $res_members = $sql_members->get_result();
                            while($row = $res_members->fetch_assoc()) {
                                echo "<span style='color: #444; font-size: 20px;'>{$row['mitglied']}</span>\n";
                            }
                            echo "</span>\n";
                        echo "</td>\n";

                        echo "<td style='width: 50px; padding: 0; text-align: center; font-weight: bold;' id='team[{$teams[$i][0]}][{$teams[$i][3]}]' contenteditable='true'>{$teams[$i][4]}</td>\n";

                    echo "</tr>\n";
                }
                $sql_members->close();
                $sql_team_names->close();

                ?>
                </tbody>
            </table>

            <button onclick="savePoints()">Punktestand Speichern</button>
            <a href="rangliste.php">Zur Rangliste und n&auml;chsten Runde</a>

        </div>

    </body>
</html>