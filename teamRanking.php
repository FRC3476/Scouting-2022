<html>
<?php
include("header.php") ?>
<script src="js/bootstrap.min.js"></script>
<body>
    <?php include("navBar.php") ?>
    <div class="container row-offcanvas row-offcanvas-left">
        <div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
            <h2>Team Ranking</h2>
            <form action="" method="get">
                <p>Enter Range of Matches (Leave blank for all matches and ranges are inclusive)</p>
                Min Match: <input class="control-label" type="number" name="min" id="min" size="10" height="10" width="40">
                Max Match: <input class="control-label" type="number" name="max" id="max" size="10" height="10" width="40">
                <button id="submit" class="btn btn-primary" onclick="">Load</button>
            </form>
            <script>
                // small script to keep form values after page reload
                var url = new URL(window.location.href);
                var min = url.searchParams.get("min");
                var max = url.searchParams.get("max");
                if (min != "" && min != null)
                  document.getElementById("min").value = min;
                if (max != "" && max != null)
                  document.getElementById("max").value = max;
            </script>
            <table class="sortable table table-hover" id="RawData" border="1">
                <tr>
                    <th>Team Number</th>
                    <th>Lead Gen ELO</th>
                    <th>Scouter Gen ELO</th>
                    <th>Avg Upper Shot Percentage</th>
                    <th>Low Climb %</th>
                    <th>Mid Climb %</th>
                    <th>High Climb %</th>
                    <th>Traversal Climb %</th>
                    <th>Total DNP</th>
                    <th>Get Average Score</th>
                    <th>Avg Teleop Upper Goal</th>
                    <th>Avg Teleop Lower Goal</th>
                    <th>Avg Auto Upper Goal</th>
                    <th>Avg Auto Lower Goal</th>
                    <th>Max Teleop Upper Goal</th>
                    <th>Max Teleop Lower Goal</th>
                    <th>Max Auto Upper Goal</th>
                    <th>Max Auto Lower Goal</th>
                    <th>OPR</th>
                </tr>
                <?php
                
                function dummy_lookup($dict, $k){
                  if (isset($dict[$k])){
                    return $dict[$k];
                  }
                  return 0;
                }
                
                $min = -1;
                $max = 1000;
                if ($_GET["min"] != "" && $_GET["max"] != "") // isset(), for some reason, returns true if the value is "". Not very helpful.
                {
                    $min = $_GET["min"];
                    $max = $_GET["max"];
                }
                include("databaseLibrary.php");
                $teamList = getTeamList($min, $max);
                $leadScoutELO = getLeadScoutELODict();
                

                foreach ($teamList as $teamNumber) {
                    $i = 0;
                    $picklist = dummy_lookup($leadScoutELO, $teamNumber);
                    // $picklist = (getPickList($teamNumber, $min, $max) - getAvgDriveRank($teamNumber, $min, $max));
                    $scoutPick = getElo($teamNumber);
                    $UpperShotPercentage = getAvgUpperShotPercentage($teamNumber, $min, $max);
                    $SingleClimbPer = getSingleClimbPercent($teamNumber, $min, $max);
                    $MidClimbPer = getDoubleClimbPercent($teamNumber, $min, $max);
                    $HighClimbPer = getTripleClimbPercent($teamNumber, $min, $max);
                    $TravClimbPer = getQuadClimbPercent($teamNumber, $min, $max);
                    // $allianceRank = getAvgDriveRank($teamNumber, $min, $max);
                    $DNP = getTotalDNP($teamNumber, $min, $max);
                    $ScoreCont = getAvgScore($teamNumber, $min, $max);
                    $avgTeleopUpper = getAvgUpperGoalT($teamNumber, $min, $max);
                    $avgTeleopLower = getAvgLowerGoalT($teamNumber, $min, $max);
                    $avgAutoUpper = getAvgUpperGoal($teamNumber, $min, $max);
                    $avgAutoLower = getAvgLowerGoal($teamNumber, $min, $max);
                    $maxTeleopUpper = getMaxUpperGoalT($teamNumber, $min, $max);
                    $maxTeleopLower = getMaxLowerGoalT($teamNumber, $min, $max);
                    $maxAutoUpper = getMaxUpperGoal($teamNumber, $min, $max);
                    $maxAutoLower = getMaxLowerGoal($teamNumber, $min, $max);
                    $OPR = getOPR($teamNumber);
                    echo ("<tr>
                    <td><a href='matchStrategy.php?team=" . $teamNumber . "'>" . $teamNumber . "</a></td>
                    <th>" . round($picklist) . "</th>
                    <th>" . ($scoutPick) . "</th>
                    <th>" . $UpperShotPercentage . "</th>
                    <th>" . round($SingleClimbPer, 3) . "</th>
                    <th>" . round($MidClimbPer, 3) . "</th>
                    <th>" . round($HighClimbPer, 3) . "</th>
                    <th>" . round($TravClimbPer, 3) . "</th>
                    <th>" . round($DNP, 3) . "</th>
                    <th>" . round($Score, 3) . "</th>
                    <th>" . round($avgTeleopUpper, 3) . "</th>
                    <th>" . round($avgTeleopLower, 3) . "</th>
                    <th>" . round($avgAutoUpper, 3) . "</th>
                    <th>" . round($avgAutoLower, 3) . "</th>
                    <th>" . $maxTeleopUpper . "</th>
                    <th>" . $maxTeleopLower . "</th>
                    <th>" . $maxAutoUpper . "</th>
                    <th>" . $maxAutoLower . "</th>
                    <th>" . round($OPR, 3) . "</th>
                    </tr>");
                }
                ?>
            </table>
        </div>
    </div>
</body>
<?php include("footer.php") ?>