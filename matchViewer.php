<html>
<?php
include("header.php");
include("navBar.php");
?>
<script src="js/bootstrap.min.js"></script>

<script>
    function postwith(to) {

        var myForm = document.createElement("form");
        myForm.method = "post";
        myForm.action = to;

        var names = [
            'match_type',
            'match'
        ];

        var nums = [
            document.getElementById('match_type').value,
            document.getElementById('match').value
        ];


        for (var i = 0; i != names.length; i++) {
            var myInput = document.createElement("input");
            myInput.setAttribute("name", names[i]);
            myInput.setAttribute("value", nums[i]);
            myForm.appendChild(myInput);
        }

        document.body.appendChild(myForm);
        myForm.submit();
        document.body.removeChild(myForm);
    }
</script>

<?php
$blueEstimate = 0;
$redEstimate = 0;
function filter($str)
{
    return filter_var($str, FILTER_UNSAFE_RAW);
}
include("databaseLibrary.php");
$ourMatches = getOurMatches();
if (
    isset($_POST['match']) && isset($_POST['match_type'])
) {
    $matchNum = filter($_POST['match']);
    $matchNum = "m" . $matchNum;
    $matchType = filter($_POST['match_type']);
    if ($matchNum != null) {
        $event = getEventRaw();
        $match = $event . "_" . $matchType . $matchNum;
        $team1Blue = getMatchAlliance($match, "blue", 0);
        $team2Blue = getMatchAlliance($match, "blue", 1);
        $team3Blue = getMatchAlliance($match, "blue", 2);
        $team1Red = getMatchAlliance($match, "red", 0);
        $team2Red = getMatchAlliance($match, "red", 1);
        $team3Red = getMatchAlliance($match, "red", 2);
    }
    $blue1Estimate = getAvgscore($team1Blue);
    $blue2Estimate = getAvgscore($team2Blue);
    $blue3Estimate = getAvgscore($team3Blue);
    $red1Estimate = getAvgscore($team1Red);
    $red2Estimate = getAvgscore($team2Red);
    $red3Estimate = getAvgscore($team3Red);
    $blueEstimate = round($blue1Estimate + $blue2Estimate + $blue3Estimate);
    $redEstimate = round($red1Estimate + $red2Estimate + $red3Estimate);
    $red1Climb = getHighestClimb($team1Red);
    $red2Climb = getHighestClimb($team2Red);
    $red3Climb = getHighestClimb($team3Red);
    $blue1Climb = getHighestClimb($team1Blue);
    $blue2Climb = getHighestClimb($team2Blue);
    $blue3Climb = getHighestClimb($team3Blue);
    $redAutoEst = getAvgUpperGoal($team1Red) + getAvgUpperGoal($team2Red) + getAvgUpperGoal($team3Red) + getAvgLowerGoal($team1Red) + getAvgLowerGoal($team2Red) + getAvgLowerGoal($team3Red);
    if ($redAutoEst >= 8) {
        $redAutoEst = 8;
    }
    $blueAutoEst = getAvgUpperGoal($team1Blue) + getAvgUpperGoal($team2Blue) + getAvgUpperGoal($team3Blue) + getAvgLowerGoal($team1Blue) + getAvgLowerGoal($team2Blue) + getAvgLowerGoal($team3Blue);
    if ($blueAutoEst >= 8) {
        $blueAutoEst = 8;
    }
    $blueTeleopEst = getAvgUpperGoalT($team1Blue) + getAvgUpperGoalT($team2Blue) + getAvgUpperGoalT($team3Blue) + getAvgLowerGoalT($team1Blue) + getAvgLowerGoalT($team2Blue) + getAvgLowerGoalT($team3Blue);

    $redAuto1 = getAuto($team1Red);
    $redAuto2 = getAuto($team2Red);
    $redAuto3 = getAuto($team3Red);
    $teamData = getTeamData($team1Red);
    $teamData1 = getTeamData($team2Red);
    $teamData2 = getTeamData($team3Red);
    $teamDataB = getTeamData($team1Blue);
    $teamDataB1 = getTeamData($team2Blue);
    $teamDataB2 = getTeamData($team3Blue);
    $redAuto = getAutoValue($team1Red) + getAutoValue($team2Red) + getAutoValue($team3Red);
    $blueAuto1 = getAuto($team1Blue);
    $blueAuto2 = getAuto($team2Blue);
    $blueAuto3 = getAuto($team3Blue);
    $totalBlueCargo = getAvgUpperGoal($team1Blue)+getAvgUpperGoalT($team1Blue)+getAvgLowerGoal($team1Blue)+getAvgLowerGoalT($team1Blue)+getAvgUpperGoal($team2Blue)+getAvgUpperGoalT($team2Blue)+getAvgLowerGoal($team2Blue)+getAvgLowerGoalT($team2Blue)+getAvgUpperGoal($team3Blue)+getAvgUpperGoalT($team3Blue)+getAvgLowerGoal($team3Blue)+getAvgLowerGoalT($team3Blue);
    $totalRedCargo = getAvgUpperGoal($team1Red)+getAvgUpperGoalT($team1Red)+getAvgLowerGoal($team1Red)+getAvgLowerGoalT($team1Red)+getAvgUpperGoal($team2Red)+getAvgUpperGoalT($team2Red)+getAvgLowerGoal($team2Red)+getAvgLowerGoalT($team2Red)+getAvgUpperGoal($team3Red)+getAvgUpperGoalT($team3Red)+getAvgLowerGoal($team3Red)+getAvgLowerGoalT($team3Red);
    $blueAuto = getAutoValue($team1Blue) + getAutoValue($team2Blue) + getAutoValue($team3Blue);
    $blueEstimate += getAvgPenalties($team1Red) + getAvgPenalties($team2Red) + getAvgPenalties($team3Red);
    $redEstimate += getAvgPenalties($team1Blue) + getAvgPenalties($team2Blue) + getAvgPenalties($team3Blue);
    $redAutoTotal = getAvgUpperGoalT($team1Red) + getAvgUpperGoalT($team2Red) + getAvgUpperGoalT($team3Red);
    $blueAutoTotal = (getAvgUpperGoal($team1Blue) + getAvgUpperGoal($team2Blue) + getAvgUpperGoal($team3Blue));
    $red1ClimbScore = (getQuadClimbPercent($team1Red)*15) + (getTripleClimbPercent($team1Red)*10) + (getDoubleClimbPercent($team1Red)*6) + (getSingleClimbPercent($team1Red)*4);
    $red2ClimbScore = (getQuadClimbPercent($team2Red)*15) + (getTripleClimbPercent($team2Red)*10) + (getDoubleClimbPercent($team2Red)*6) + (getSingleClimbPercent($team2Red)*4);
    $red3ClimbScore = (getQuadClimbPercent($team3Red)*15) + (getTripleClimbPercent($team3Red)*10) + (getDoubleClimbPercent($team3Red)*6) + (getSingleClimbPercent($team3Red)*4);
    $redTotalClimb = ($red1ClimbScore + $red2ClimbScore + $red3ClimbScore);
    $blue1ClimbScore = (getQuadClimbPercent($team1Blue)*15) + (getTripleClimbPercent($team1Blue)*10) + (getDoubleClimbPercent($team1Blue)*6) + (getSingleClimbPercent($team1Blue)*4);
    $blue2ClimbScore = (getQuadClimbPercent($team2Blue)*15) + (getTripleClimbPercent($team2Blue)*10) + (getDoubleClimbPercent($team2Blue)*6) + (getSingleClimbPercent($team2Blue)*4);
    $blue3ClimbScore = (getQuadClimbPercent($team3Blue)*15) + (getTripleClimbPercent($team3Blue)*10) + (getDoubleClimbPercent($team3Blue)*6) + (getSingleClimbPercent($team3Blue)*4);
    $blueTotalClimb = ($blue1ClimbScore + $blue2ClimbScore + $blue3ClimbScore);
    $redTotalScore = getAvgscore($team1Red) + getAvgscore($team2Red) + getAvgscore($team3Red);
    $blueTotalScore = getAvgscore($team1Blue) + getAvgscore($team2Blue) + getAvgscore($team3Blue);
}
?>

<body>
    <div class="container row-offcanvas row-offcanvas-left">
        <div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">

            <a>
                <h3><b><u>Our Matches:</u></b></h3>
                <h10><?php
                        for ($i = 0; $i < count($ourMatches); $i++) {
                            if (substr($ourMatches[$i], 0, 2) == "f1") {
                                $matchType1 = "f1";
                                if (substr($ourMatches[$i], 2, 4) == "m1") {
                                    $match1 = "1";
                                } else if (substr($ourMatches[$i], 2, 4) == "m2") {
                                    $match1 = "2";
                                } else {
                                    $match1 = "3";
                                }
                            }
                            if (substr($ourMatches[$i], 0, 3) == "sf1") {
                                $matchType1 = "sf1";
                                if (substr($ourMatches[$i], 3, 5) == "m1") {
                                    $match1 = "1";
                                } else if (substr($ourMatches[$i], 3, 5) == "m2") {
                                    $match1 = "2";
                                } else {
                                    $match1 = "3";
                                }
                            }
                            if (substr($ourMatches[$i], 0, 3) == "sf2") {
                                $matchType1 = "sf2";
                                if (substr($ourMatches[$i], 3, 5) == "m1") {
                                    $match1 = "1";
                                } else if (substr($ourMatches[$i], 3, 5) == "m2") {
                                    $match1 = "2";
                                } else {
                                    $match1 = "3";
                                }
                            }

                            if (substr($ourMatches[$i], 0, 3) == "qf1") {
                                $matchType1 = "qf1";
                                if (substr($ourMatches[$i], 3, 5) == "m1") {
                                    $match1 = "1";
                                } else if (substr($ourMatches[$i], 3, 5) == "m2") {
                                    $match1 = "2";
                                } else {
                                    $match1 = "3";
                                }
                            }
                            if (substr($ourMatches[$i], 0, 3) == "qf2") {
                                $matchType1 = "qf2";
                                if (substr($ourMatches[$i], 3, 5) == "m1") {
                                    $match1 = "1";
                                } else if (substr($ourMatches[$i], 3, 5) == "m2") {
                                    $match1 = "2";
                                } else {
                                    $match1 = "3";
                                }
                            }
                            if (substr($ourMatches[$i], 0, 3) == "qf3") {
                                $matchType1 = "qf3";
                                if (substr($ourMatches[$i], 3, 5) == "m1") {
                                    $match1 = "1";
                                } else if (substr($ourMatches[$i], 3, 5) == "m2") {
                                    $match1 = "2";
                                } else {
                                    $match1 = "3";
                                }
                            }
                            if (substr($ourMatches[$i], 0, 3) == "qf4") {
                                $matchType1 = "qf4";
                                if (substr($ourMatches[$i], 3, 5) == "m1") {
                                    $match1 = "1";
                                } else if (substr($ourMatches[$i], 3, 5) == "m2") {
                                    $match1 = "2";
                                } else {
                                    $match1 = "3";
                                }
                            }
                            if (substr($ourMatches[$i], 0, 2) == "qm") {
                                $matchType1 = "q";
                                $match1 = substr($ourMatches[$i], 2);
                            }


                            echo '  <a href="matchViewer.php?match=' . $match1 . '&match_type=' . $matchType1 . '">' . $ourMatches[$i] . '</a>,  ';
                        }
                        ?></h10>
            </a>
            <a>
                <h3><b><u>Match Number:</u></b></h3>
            </a>
            <select id="match_type" value="<?php $types = ((isset($_GET["match_type"])) ? htmlspecialchars($_GET["match_type"]) : ""); ?>">
                <option <?php if ($types == "q") : ?>selected="selected" <?php endif; ?> value="q">Qual</option>
                <option <?php if ($types == "qf1") : ?>selected="selected" <?php endif; ?> value="qf1">QF 1</option>
                <option <?php if ($types == "qf2") : ?>selected="selected" <?php endif; ?> value="qf2">QF 2</option>
                <option <?php if ($types == "qf3") : ?>selected="selected" <?php endif; ?> value="qf3">QF 3</option>
                <option <?php if ($types == "qf4") : ?>selected="selected" <?php endif; ?> value="qf4">QF 4</option>
                <option <?php if ($types == "sf1") : ?>selected="selected" <?php endif; ?> value="sf1">SF 1</option>
                <option <?php if ($types == "sf2") : ?>selected="selected" <?php endif; ?> value="sf2">SF 2</option>
                <option <?php if ($types == "f1") : ?>selected="selected" <?php endif; ?> value="f1">Final</option>
            </select>
            <input type="text" name="match" id="match" value="<?php echo ((isset($_GET["match"])) ? htmlspecialchars($_GET["match"]) : ""); ?>" size="8" class="form-control">
            <br />
            <script>
                window.history.pushState('', '', 'matchViewer.php');
            </script>
            <button id="submit" class="btn btn-primary" onclick="postwith('');">Submit</button>
            <br />
        </div>
    </div>

    <!-- KEYUR ONLY EDIT BELOW THIS OKKKKKKK PLEASE PLEASE PLEASE DON'T TOUNCH ANYTHING ABOVE-->
    <!-- KEYUR ONLY EDIT BELOW THIS OKKKKKKK PLEASE PLEASE PLEASE DON'T TOUNCH ANYTHING ABOVE-->
    <!-- KEYUR ONLY EDIT BELOW THIS OKKKKKKK PLEASE PLEASE PLEASE DON'T TOUNCH ANYTHING ABOVE-->

    <div class="container row-offcanvas row-offcanvas-left">
        <div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
            <?php
            echo ("<a><h3><b>" . "Match: " . $matchType . $matchNum . "</b></h3></a>");
            ?>
            <div class="row">
                <table class="table" style="width:100%">
                    <tr>
                        <th>
                            <th></th>
                            <th>Red Alliance</th>
                            <th>Blue Alliance</th>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <th>Avg Total Points</th>
                            <th><?php echo (($redTotalScore)); ?></th>
                            <th><?php echo (($blueTotalScore)); ?></th>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <th>Avg Total Cargo</th>
                            <th><?php echo($totalRedCargo);?></th>
                            <th><?php echo($totalBlueCargo);?></th>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <th>Avg Climb Points</th>
                            <th><?php echo (($redTotalClimb)); ?></th>
                            <th><?php echo (($blueTotalClimb)); ?></th>
                        </th>
                    </tr>
                </table>
            </div>
            <div class="row">
                <div class="column1">
                    <div class="table-responsive">
                        <table class="table">
                            <tr class="success">
                                <td>Team Number</td>
                                <td><?php echo (($team1Red)); ?></td>
                                <td><?php echo (($team2Red)); ?></td>
                                <td><?php echo (($team3Red)); ?></td>
                                <td>Total</td>
                            </tr>
                            <tr class="danger">
                                <td>Predicted Red Score:</td>
                                <td><?php echo round(($red1Estimate)); ?></td>
                                <td><?php echo round(($red2Estimate)); ?></td>
                                <td><?php echo round(($red3Estimate)); ?></td>
                                <td><?php echo round(($redEstimate)); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Have Autos</td>
                                <td><?php echo ($redAuto1); ?></td>
                                <td><?php echo ($redAuto2); ?></td>
                                <td><?php echo ($redAuto3); ?></td>
                                <td><?php echo ($redAuto); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Avg Auto Upper</td>
                                <td><?php echo (getAvgUpperGoal($team1Red)); ?></td>
                                <td><?php echo (getAvgUpperGoal($team2Red)); ?></td>
                                <td><?php echo (getAvgUpperGoal($team3Red)); ?></td>
                                <td><?php echo ($redAutoTotal); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Avg Auto Lower</td>
                                <td><?php echo round(getAvgLowerGoal($team1Red), 3); ?></td>
                                <td><?php echo round(getAvgLowerGoal($team2Red), 3); ?></td>
                                <td><?php echo round(getAvgLowerGoal($team3Red), 3); ?></td>
                                <td><?php echo (getAvgLowerGoal($team1Red) + getAvgLowerGoal($team2Red) + getAvgLowerGoal($team3Red)); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Avg Teleop Upper</td>
                                <td><?php echo (getAvgUpperGoalT($team1Red)); ?></td>
                                <td><?php echo (getAvgUpperGoalT($team2Red)); ?></td>
                                <td><?php echo (getAvgUpperGoalT($team3Red)); ?></td>
                                <td><?php echo (getAvgUpperGoalT($team1Red) + getAvgUpperGoalT($team2Red) + getAvgUpperGoalT($team3Red)); ?></td>
                            </tr>
                            </tr>
                            <tr class="danger">
                                <td>Avg Teleop Lower</td>
                                <td><?php echo round(getAvgLowerGoalT($team1Red), 3); ?></td>
                                <td><?php echo round(getAvgLowerGoalT($team2Red), 3); ?></td>
                                <td><?php echo round(getAvgLowerGoalT($team3Red), 3); ?></td>
                                <td><?php echo (getAvgLowerGoalT($team1Red) + getAvgLowerGoalT($team2Red) + getAvgLowerGoalT($team3Red)); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Cycle Count</td>
                                <td><?php echo round(getAvgCycleCount($team1Red), 3); ?></td>
                                <td><?php echo round(getAvgCycleCount($team2Red), 3); ?></td>
                                <td><?php echo round(getAvgCycleCount($team3Red), 3); ?></td>
                                <td><?php echo (getAvgCycleCount($team3Red) + getAvgCycleCount($team2Red) + getAvgCycleCount($team1Red)); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Traversal Climb Percentage</td>
                                <td><?php echo round(100 * getQuadClimbPercent($team1Red), 3); ?>%</td>
                                <td><?php echo round(100 * getQuadClimbPercent($team2Red), 3); ?>%</td>
                                <td><?php echo round(100 * getQuadClimbPercent($team3Red), 3); ?>%</td>
                                <td><?php echo 100 * (1 - ((1 - getQuadClimbPercent($team3Red)) * (1 - getQuadClimbPercent($team2Red)) * (1 - getQuadClimbPercent($team1Red)))); ?>%</td>
                            </tr>
                            <tr class="danger">
                                <td>High Climb Percentage</td>
                                <td><?php echo round(100 * getTripleClimbPercent($team1Red), 3); ?>%</td>
                                <td><?php echo round(100 * getTripleClimbPercent($team2Red), 3); ?>%</td>
                                <td><?php echo round(100 * getTripleClimbPercent($team3Red), 3); ?>%</td>
                                <td><?php echo 100 * (1 - ((1 - getTripleClimbPercent($team3Red)) * (1 - getTripleClimbPercent($team2Red)) * (1 - getTripleClimbPercent($team1Red)))); ?>%</td>
                            </tr>
                            <tr class="danger">
                                <td>Med Climb Percentage</td>
                                <td><?php echo round(100 * getDoubleClimbPercent($team1Red), 3); ?>%</td>
                                <td><?php echo round(100 * getDoubleClimbPercent($team2Red), 3); ?>%</td>
                                <td><?php echo round(100 * getDoubleClimbPercent($team3Red), 3); ?>%</td>
                                <td><?php echo 100 * (1 - ((1 - getDoubleClimbPercent($team3Red)) * (1 - getDoubleClimbPercent($team2Red)) * (1 - getDoubleClimbPercent($team1Red)))); ?>%</td>
                            </tr>
                            <tr class="danger">
                                <td>Low Climb Percentage</td>
                                <td><?php echo round(100 * getSingleClimbPercent($team1Red), 3); ?>%</td>
                                <td><?php echo round(100 * getSingleClimbPercent($team2Red), 3); ?>%</td>
                                <td><?php echo round(100 * getSingleClimbPercent($team3Red), 3); ?>%</td>
                                <td><?php echo 100 * (1 - ((1 - getSingleClimbPercent($team3Red)) * (1 - getSingleClimbPercent($team2Red)) * (1 - getSingleClimbPercent($team1Red)))); ?>%</td>
                            </tr>
                        </table>
                    </div>
                    <canvas id="myCanvas" width="500" height="250" style="border:1px solid #d3d3d3;"></canvas>
                    <script type="text/javascript">
                        var canvas = document.getElementById('myCanvas');
                        var context = canvas.getContext('2d');
                        var drawLine = false;
                        var oldCoor = {};
                        var i = 1;
                        var t;
                        var imageObj = new Image();
                        var matchToPoints = [];
                        var matchToPoints1 = [];
                        var matchToPoints4 = [];
                        var matchToPoints5 = [];
                        var matchToPoints6 = [];
                        var matchToPoints20 = [];
                        var dataList = [];
                        <?php

                        for ($i = 0; $i != sizeof($teamData[8]); $i++) {
                            echo ("matchToPoints[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][25] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamData[8]); $i++) {
                            echo ("matchToPoints1[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][24] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamData1[8]); $i++) {
                            echo ("matchToPoints4[" . $teamData1[8][$i][2] . "] = " . $teamData1[8][$i][25] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamData1[8]); $i++) {
                            echo ("matchToPoints5[" . $teamData1[8][$i][2] . "] = " . $teamData1[8][$i][24] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamData2[8]); $i++) {
                            echo ("matchToPoints6[" . $teamData2[8][$i][2] . "] = " . $teamData2[8][$i][25] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamData2[8]); $i++) {
                            echo ("matchToPoints20[" . $teamData2[8][$i][2] . "] = " . $teamData2[8][$i][24] . ";");
                        }

                        ?>
                        <?php


                        for ($i = 0; $i != sizeof($teamData[8]); $i++) {
                            $a += ('' . $teamData[8][$i][2] . ',');
                        }
                        $a = substr($a, 0, -2);

                        ?>
                        imageObj.onload = function() {
                            makeCanvasReady();
                            drawPoint4();
                            var ctx2 = document.getElementById("dataChart3").getContext("2d");
                            window.myLine = new Chart(ctx2).Line(lineChartData, {
                                responsive: true
                            });
                        };
                        imageObj.src = 'images/field.png';

                        function makeCanvasReady() {
                            context.clearRect(0, 0, 500, 250);
                            context.drawImage(imageObj, 0, 0, 500, 250);
                            console.log("hi");
                        }

                        function drawPoint4() {
                            for (var j = 0; j != 200; j++) {
                                var a = matchToPoints[j];
                                var b = matchToPoints1[j];
                                if (a != null) {
                                    for (var i = 0; i != a.length; i++) {
                                        if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.9)) {
                                            context.fillStyle = "#3cff00";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                            console.log(b[i][1]);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.5)) {
                                            context.fillStyle = "#fff200";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.3)) {
                                            context.fillStyle = "#ff9100";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0)) {
                                            context.fillStyle = "#ff0000";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else {
                                            context.fillStyle = "#000000";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        }
                                    }
                                } else {
                                    continue;
                                    console.log("fail");
                                }
                            }
                            for (var j = 0; j != 200; j++) {
                                var a = matchToPoints4[j];
                                var b = matchToPoints5[j];
                                if (a != null) {
                                    for (var i = 0; i != a.length; i++) {
                                        if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.9)) {
                                            context.fillStyle = "#3cff00";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                            console.log(b[i][1]);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.5)) {
                                            context.fillStyle = "#fff200";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.3)) {
                                            context.fillStyle = "#ff9100";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0)) {
                                            context.fillStyle = "#ff0000";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else {
                                            context.fillStyle = "#000000";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        }
                                    }
                                } else {
                                    continue;
                                    console.log("fail");
                                }
                            }
                            for (var j = 0; j != 200; j++) {
                                var a = matchToPoints6[j];
                                var b = matchToPoints20[j];
                                if (a != null) {
                                    for (var i = 0; i != a.length; i++) {
                                        if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.9)) {
                                            context.fillStyle = "#3cff00";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                            console.log(b[i][1]);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.5)) {
                                            context.fillStyle = "#fff200";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.3)) {
                                            context.fillStyle = "#ff9100";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0)) {
                                            context.fillStyle = "#ff0000";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else {
                                            context.fillStyle = "#000000";
                                            context.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        }
                                    }
                                } else {
                                    continue;
                                    console.log("fail");
                                }
                            }
                        }
                    </script>

                </div>

                <div class="column1">

                    <div class="table-responsive">
                        <table class="table">
                            <tr class="success">
                                <td>Team Number</td>
                                <td><?php echo (($team1Blue)); ?></td>
                                <td><?php echo (($team2Blue)); ?></td>
                                <td><?php echo (($team3Blue)); ?></td>
                                <td>Total</td>
                            </tr>
                            <tr class="info">
                                <td>Predicted Blue Score:</td>
                                <td><?php echo round(($blue1Estimate)); ?></td>
                                <td><?php echo round(($blue2Estimate)); ?></td>
                                <td><?php echo round(($blue3Estimate)); ?></td>
                                <td><?php echo (($blueEstimate)); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Have Autos</td>
                                <td><?php echo ($blueAuto1); ?></td>
                                <td><?php echo ($blueAuto2); ?></td>
                                <td><?php echo ($blueAuto3); ?></td>
                                <td><?php echo ($blueAuto); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Avg Auto Upper</td>
                                <td><?php echo (getAvgUpperGoal($team1Blue)); ?></td>
                                <td><?php echo (getAvgUpperGoal($team2Blue)); ?></td>
                                <td><?php echo (getAvgUpperGoal($team3Blue)); ?></td>
                                <td><?php echo ($blueAutoTotal); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Avg Auto Lower</td>
                                <td><?php echo round(getAvgLowerGoal($team1Blue), 3); ?></td>
                                <td><?php echo round(getAvgLowerGoal($team2Blue), 3); ?></td>
                                <td><?php echo round(getAvgLowerGoal($team3Blue), 3); ?></td>
                                <td><?php echo (getAvgLowerGoal($team1Blue) + getAvgLowerGoal($team2Blue) + getAvgLowerGoal($team3Blue)); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Avg Teleop Upper</td>
                                <td><?php echo (getAvgUpperGoalT($team1Blue)); ?></td>
                                <td><?php echo (getAvgUpperGoalT($team2Blue)); ?></td>
                                <td><?php echo (getAvgUpperGoalT($team3Blue)); ?></td>
                                <td><?php echo (getAvgUpperGoalT($team1Blue) + getAvgUpperGoalT($team2Blue) + getAvgUpperGoalT($team3Blue)); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Avg Teleop Lower</td>
                                <td><?php echo round(getAvgLowerGoalT($team1Blue), 3); ?></td>
                                <td><?php echo round(getAvgLowerGoalT($team2Blue), 3); ?></td>
                                <td><?php echo round(getAvgLowerGoalT($team3Blue), 3); ?></td>
                                <td><?php echo (getAvgLowerGoalT($team1Blue) + getAvgLowerGoalT($team2Blue) + getAvgLowerGoalT($team3Blue)); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Cycle Count</td>
                                <td><?php echo round(getAvgCycleCount($team1Blue), 3); ?></td>
                                <td><?php echo round(getAvgCycleCount($team2Blue), 3); ?></td>
                                <td><?php echo round(getAvgCycleCount($team3Blue), 3); ?></td>
                                <td><?php echo (getAvgCycleCount($team3Blue) + getAvgCycleCount($team2Blue) + getAvgCycleCount($team1Blue)); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Traversal Climb Percentage</td>
                                <td><?php echo round(100 * getQuadClimbPercent($team1Blue), 3); ?>%</td>
                                <td><?php echo round(100 * getQuadClimbPercent($team2Blue), 3); ?>%</td>
                                <td><?php echo round(100 * getQuadClimbPercent($team3Blue), 3); ?>%</td>
                                <td><?php echo 100 * (1 - ((1 - getQuadClimbPercent($team3Blue)) * (1 - getQuadClimbPercent($team2Blue)) * (1 - getQuadClimbPercent($team1Blue)))); ?>%</td>
                            </tr>
                            <tr class="info">
                                <td>High Climb Percentage</td>
                                <td><?php echo round(100 * getTripleClimbPercent($team1Blue), 3); ?>%</td>
                                <td><?php echo round(100 * getTripleClimbPercent($team2Blue), 3); ?>%</td>
                                <td><?php echo round(100 * getTripleClimbPercent($team3Blue), 3); ?>%</td>
                                <td><?php echo 100 * (1 - ((1 - getTripleClimbPercent($team3Blue)) * (1 - getTripleClimbPercent($team2Blue)) * (1 - getTripleClimbPercent($team1Blue)))); ?>%</td>
                            </tr>
                            <tr class="info">
                                <td>Med Climb Percentage</td>
                                <td><?php echo round(100 * getDoubleClimbPercent($team1Blue), 3); ?>%</td>
                                <td><?php echo round(100 * getDoubleClimbPercent($team2Blue), 3); ?>%</td>
                                <td><?php echo round(100 * getDoubleClimbPercent($team3Blue), 3); ?>%</td>
                                <td><?php echo 100 * (1 - ((1 - getDoubleClimbPercent($team3Blue)) * (1 - getDoubleClimbPercent($team2Blue)) * (1 - getDoubleClimbPercent($team1Blue)))); ?>%</td>
                            </tr>
                            <tr class="info">
                                <td>Low Climb Percentage</td>
                                <td><?php echo round(100 * getSingleClimbPercent($team1Blue), 3); ?>%</td>
                                <td><?php echo round(100 * getSingleClimbPercent($team2Blue), 3); ?>%</td>
                                <td><?php echo round(100 * getSingleClimbPercent($team3Blue), 3); ?>%</td>
                                <td><?php echo 100 * (1 - ((1 - getSingleClimbPercent($team3Blue)) * (1 - getSingleClimbPercent($team2Blue)) * (1 - getSingleClimbPercent($team1Blue)))); ?>%</td>
                            </tr>
                        </table>
                    </div>
                    <canvas id="myCanvas1" width="500" height="250" style="border:1px solid #d3d3d3;"></canvas>
                    <script type="text/javascript">
                        var canvas1 = document.getElementById('myCanvas1');
                        var context1 = canvas1.getContext('2d');
                        var drawLine = false;
                        var i = 1;
                        var imageObj1 = new Image();
                        var matchToPoints2 = [];
                        var matchToPoints21 = [];
                        var matchToPoints24 = [];
                        var matchToPoints25 = [];
                        var matchToPoints26 = [];
                        var matchToPoints220 = [];
                        var dataList = [];
                        <?php

                        for ($i = 0; $i != sizeof($teamDataB[8]); $i++) {
                            echo ("matchToPoints2[" . $teamDataB[8][$i][2] . "] = " . $teamDataB[8][$i][25] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamDataB[8]); $i++) {
                            echo ("matchToPoints21[" . $teamDataB[8][$i][2] . "] = " . $teamDataB[8][$i][24] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamDataB1[8]); $i++) {
                            echo ("matchToPoints24[" . $teamDataB1[8][$i][2] . "] = " . $teamDataB1[8][$i][25] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamDataB1[8]); $i++) {
                            echo ("matchToPoints25[" . $teamDataB1[8][$i][2] . "] = " . $teamDataB1[8][$i][24] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamDataB2[8]); $i++) {
                            echo ("matchToPoints26[" . $teamDataB2[8][$i][2] . "] = " . $teamDataB2[8][$i][25] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamDataB2[8]); $i++) {
                            echo ("matchToPoints220[" . $teamDataB2[8][$i][2] . "] = " . $teamDataB2[8][$i][24] . ";");
                        }

                        ?>
                        <?php


                        for ($i = 0; $i != sizeof($teamDataB[8]); $i++) {
                            $a += ('' . $teamDataB[8][$i][2] . ',');
                        }
                        $a = substr($a, 0, -2);

                        ?>
                        imageObj1.onload = function() {
                            makeCanvasReady1();
                            drawPoint3();
                            var ctx1 = document.getElementById("dataChart4").getContext("2d");
                            window.myLine = new Chart(ctx1).Line(lineChartData1, {
                                responsive: true
                            });
                        };
                        imageObj1.src = 'images/field.png';

                        function makeCanvasReady1() {
                            context1.clearRect(0, 0, 500, 250);
                            context1.drawImage(imageObj1, 0, 0, 500, 250);
                            console.log("hi");
                        }

                        function drawPoint3() {
                            for (var j = 0; j != 200; j++) {
                                var a = matchToPoints2[j];
                                var b = matchToPoints21[j];
                                if (a != null) {
                                    for (var i = 0; i != a.length; i++) {
                                        if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.9)) {
                                            context1.fillStyle = "#3cff00";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                            console.log(b[i][1]);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.5)) {
                                            context1.fillStyle = "#fff200";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.3)) {
                                            context1.fillStyle = "#ff9100";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0)) {
                                            context1.fillStyle = "#ff0000";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else {
                                            context1.fillStyle = "#000000";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        }
                                    }
                                } else {
                                    continue;
                                    console.log("fail");
                                }
                            }
                            for (var j = 0; j != 200; j++) {
                                var a = matchToPoints24[j];
                                var b = matchToPoints25[j];
                                if (a != null) {
                                    for (var i = 0; i != a.length; i++) {
                                        if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.9)) {
                                            context1.fillStyle = "#3cff00";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                            console.log(b[i][1]);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.5)) {
                                            context1.fillStyle = "#fff200";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.3)) {
                                            context1.fillStyle = "#ff9100";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0)) {
                                            context1.fillStyle = "#ff0000";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else {
                                            context1.fillStyle = "#000000";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        }
                                    }
                                } else {
                                    continue;
                                    console.log("fail");
                                }
                            }
                            for (var j = 0; j != 200; j++) {
                                var a = matchToPoints26[j];
                                var b = matchToPoints220[j];
                                if (a != null) {
                                    for (var i = 0; i != a.length; i++) {
                                        if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.9)) {
                                            context1.fillStyle = "#3cff00";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                            console.log(b[i][1]);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.5)) {
                                            context1.fillStyle = "#fff200";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0.3)) {
                                            context1.fillStyle = "#ff9100";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else if (((b[i][1] / (b[i][2] + b[i][1])) >= 0)) {
                                            context1.fillStyle = "#ff0000";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        } else {
                                            context1.fillStyle = "#000000";
                                            context1.fillRect((5 / 6) * (a[i][0]), (5 / 6) * (a[i][1]), 5, 5);
                                        }
                                    }
                                } else {
                                    continue;
                                    console.log("fail");
                                }
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>


<style>
    .column1 {
        float: left;
        width: 50%;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }
</style>

<?php include("footer.php"); ?>

</html>