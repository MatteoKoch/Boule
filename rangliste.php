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
        <tr><td colspan="3" style="text-align: center; font-weight: bold;"><?= sprintf($lang['RANGLISTE_TITEL'], $_SESSION['runde']) ?></td></tr>
        <tr>
            <td style="font-weight: bold"><?= $lang['RANGLISTE_POSITION'] ?></td>
            <td style="font-weight: bold"><?= $lang['RANGLISTE_TEAM'] ?></td>
            <td style="font-weight: bold"><?= $lang['RANGLISTE_PUNKTE'] ?></td>
        </tr>
        </thead>
        <tbody>
        <?php

        $sql_all_teams = $conn->prepare("SELECT id FROM teams");
        $sql_all_teams->execute();
        $res_all_teams = $sql_all_teams->get_result();
        $sql_all_teams->close();

        $points = array();

        //Sortierpriorität 1 (Anzahl der gew. Spiele)
        //SELECT count(*) FROM `spiele` WHERE team_1_id = ? AND team_1_punkte > team_2_punkte
        //SELECT count(*) FROM `spiele` WHERE team_2_id = ? AND team_2_punkte > team_1_punkte

        //Sortierpriorität 2 (Summe aus Differenzen)
        //SELECT team_1_punkte, team_2_punkte FROM `spiele` WHERE team_1_id = ? AND team_1_punkte > team_2_punkte
        //SELECT team_1_punkte, team_2_punkte FROM `spiele` WHERE team_2_id = ? AND team_2_punkte > team_1_punkte

        //STRUKTUR
        //0:
        //  - Team Id
        //  - Gew. Spiele
        //  - Summe der Differenz der Punkte der gew. Spiele

        while($row_points = $res_all_teams->fetch_assoc()) {
            $sum = 0;
            for($i = 1; $i < 3; $i++) {
                $sql_points = $conn->prepare("SELECT sum(team_{$i}_punkte) as anz FROM spiele WHERE team_{$i}_id = ?");
                $sql_points->bind_param("i", $row_points['id']);
                $sql_points->execute();
                $res_points = $sql_points->get_result();
                while($row_points2 = $res_points->fetch_assoc()) {
                    $sum += $row_points2['anz'];
                }
            }
            array_push($points, array($row_points['id'], $sum));
        }

        function cmp($a, $b) {
            return $a[1] - $b[1];
        }

        uasort($points, "cmp");
        $points = array_reverse($points);

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