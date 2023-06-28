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
    <title>Rangliste</title>
    <link href="styles/style.css" rel="stylesheet" type="text/css">
</head>
<body style="padding-top: 30px !important;;">

<div style="display: grid; gap: 50px;">
<table class="spiel">
    <thead>
    <tr><td colspan="3" style="text-align: center; font-weight: bold;">Rangliste (Runde Nr. <?= $_SESSION['runde'] ?>)</td></tr>
    <tr>
        <td style="font-weight: bold">Position</td>
        <td style="font-weight: bold">Team</td>
        <td style="font-weight: bold">Punkte</td>
    </tr>
    </thead>
    <tbody>
    <?php

    $sql_all_teams = $conn->prepare("SELECT id FROM teams");
    $sql_all_teams->execute();
    $res_all_teams = $sql_all_teams->get_result();
    $sql_all_teams->close();

    $points = array();

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
<div class="col2 gap20">
    <a href="rangliste.php">Zur&uuml;ck zur Rangliste</a>
    <button onclick="window.print()">Drucken</button>
</div>

</div>
</body>
</html>