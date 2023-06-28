<?php require_once "db_conn.php"; ?>
<table style="width: 100%;">
    <thead>
    <tr><td colspan="2" style="text-align: center; font-weight: bold;">Teams</td></tr>
    </thead>
    <tbody>
    <?php

    $sql_teams = $conn->prepare("SELECT * FROM teams");
    $sql_teams->execute();
    $res_teams = $sql_teams->get_result();
    $sql_teams->close();

    $teams = $res_teams->fetch_all();

    $sql_members = $conn->prepare("SELECT * FROM teams_mitglieder WHERE teams_id = ?");
    for($i = 0; $i < count($teams); $i++) {
        echo "<tr>\n";
            echo "<td style='display: flex; gap: 20px;'>\n";
                echo "{$teams[$i][1]}\n";
                echo "<span style='display: flex; gap: 10px; align-items: end;'>\n";
                $sql_members->bind_param("i", $teams[$i][0]);
                $sql_members->execute();
                $res_members = $sql_members->get_result();
                while($row = $res_members->fetch_assoc()) {
                    echo "<span style='color: #444; font-size: 20px;'>{$row['mitglied']}</span>\n";
                }
                echo "</span>\n";
            echo "</td>\n";
        echo "</tr>\n";
    }
    $sql_members->close();

    ?>
    </tbody>
</table>
