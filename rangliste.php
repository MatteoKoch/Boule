<?php

session_start();

if(!isset($_SESSION['admin'])) {
    header("Location: login");
    die();
}

require_once "db_conn.php";
require_once "lang/de.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Rangliste</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php require_once "header.php"; ?>

<div style="display: grid; gap: 50px;">
    <table class="spiel" style="min-width: 800px;">
        <thead>
        <tr><td colspan="4" style="text-align: center;"><?= sprintf($lang['RANGLISTE_TITEL'], $_SESSION['runde']) ?></td></tr>
        <tr>
            <td><?= $lang['RANGLISTE_POSITION'] ?></td>
            <td><?= $lang['RANGLISTE_TEAM'] ?></td>
            <td><?= $lang['RANGLISTE_GEW_SPIELE'] ?></td>
            <td><?= $lang['RANGLISTE_PUNKTE'] ?></td>
        </tr>
        </thead>
        <tbody>
        <?php

        $sql_all_teams = $conn->prepare("SELECT id FROM teams");
        $sql_all_teams->execute();
        $res_all_teams = $sql_all_teams->get_result();
        $sql_all_teams->close();

        $points = array();

        //AKTUELL:
        //0:
        //  - Team Id
        //  - Punkte

        //NEUE STRUKTUR:
        //0:
        //  - Team Id
        //  - Gew. Spiele
        //  - Summe der Differenz der Punkte der gew. Spiele

        while($row_points = $res_all_teams->fetch_assoc()) {
            $sum = 0;
            $won = 0;
            $sql_score1 = $conn->prepare("SELECT team_1_punkte, team_2_punkte FROM spiele WHERE team_1_id = ?");
            $sql_score1->bind_param("i", $row_points['id']);
            $sql_score1->execute();
            $res_score1 = $sql_score1->get_result();
            while($row_score1 = $res_score1->fetch_assoc()) {
                $sum += $row_score1['team_1_punkte'] - $row_score1['team_2_punkte'];
                if($row_score1['team_1_punkte'] > $row_score1['team_2_punkte']) $won++;
            }
            $sql_score2 = $conn->prepare("SELECT team_1_punkte, team_2_punkte FROM spiele WHERE team_2_id = ?");
            $sql_score2->bind_param("i", $row_points['id']);
            $sql_score2->execute();
            $res_score2 = $sql_score2->get_result();
            while($row_score2 = $res_score2->fetch_assoc()) {
                $sum += $row_score2['team_2_punkte'] - $row_score2['team_1_punkte'];
                if($row_score1['team_1_punkte'] < $row_score1['team_2_punkte']) $won++;
            }
            array_push($points, array($row_points['id'], $won, $sum));
        }

        function bubbleSort($arr) {
            for($i = 0; $i < count($arr)-1; $i++) {
                for($j = $i+1; $j < count($arr); $j++) {
                    if($arr[$i][1] == $arr[$j][1] && $arr[$i][2] < $arr[$j][2]) {
                        $save = $arr[$i];
                        $arr[$i] = $arr[$j];
                        $arr[$j] = $save;
                    }
                }
            }
            return $arr;
        }

        function cmp($a, $b) {
            return $a[1] - $b[1];
        }

        uasort($points, "cmp");
        $points = array_reverse($points);
        $points = bubbleSort($points);

        $sql_team_names = $conn->prepare("SELECT * FROM teams WHERE id = ?");
        $sql_members = $conn->prepare("SELECT * FROM teams_mitglieder WHERE teams_id = ?");
        foreach($points as $key => $team) {
            echo "<tr>\n";

            $keypone = $key+1;
            echo "<td style='width: 100px; font-weight: bold;'>{$keypone}.</td>\n";

            echo "<td>\n";
            $sql_team_names->bind_param("i", $team[0]);
            $sql_team_names->execute();
            $res_team_names = $sql_team_names->get_result();
            echo "{$res_team_names->fetch_assoc()['name']}\n";
            echo "<span style='display: flex; gap: 10px; align-items: end;'>\n";
            $sql_members->bind_param("i", $team[0]);
            $sql_members->execute();
            $res_members = $sql_members->get_result();
            while($row = $res_members->fetch_assoc()) {
                echo "<span style='color: #444; font-size: 20px;'>{$row['mitglied']}</span>\n";
            }
            echo "</span>\n";
            echo "</td>\n";

            echo "<td style='width: 100px; font-weight: bold; text-align: right;'>{$team[1]}</td>\n";
            echo "<td style='width: 100px; font-weight: bold; text-align: right;'>{$team[2]}</td>\n";

            echo "</tr>\n";
        }
        $sql_members->close();
        $sql_team_names->close();

        ?>
        </tbody>
    </table>

    <div class="col2 gap20 no-print">
        <button onclick="window.print();"><?= $lang['RANGLISTE_DRUCKEN'] ?></button>
        <form action="create_games.php" method="post">
            <?php
            foreach($points as $key => $team) {
                echo "<input type='hidden' name='points[{$key}][0]' value='{$team[0]}'>\n";
                echo "<input type='hidden' name='points[{$key}][1]' value='{$team[1]}'>\n";
            }
            ?>
            <button type="submit"><?= $lang['RANGLISTE_WEITER'] ?></button>
        </form>
    </div>

</div>

</body>
</html>