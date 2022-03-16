<html>
<?php
include("header.php");
include("navBar.php");
?>
<script>
    function postwith(to) {

        var myForm = document.createElement("form");
        myForm.method = "post";
        myForm.action = to;

        var names = [
            'match'
        ];

        var nums = [
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
if (
    isset($_POST['match'])
) {
    include("databaseLibrary.php");
    $matchNum = filter($_POST['match']);
    if ($matchNum != null) {
        $event = getEvent();
        $match = $event . $matchNum;
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
    $redAuto = getAutoValue($team1Red) + getAutoValue($team2Red) + getAutoValue($team3Red);
    $blueAuto1 = getAuto($team1Blue);
    $blueAuto2 = getAuto($team2Blue);
    $blueAuto3 = getAuto($team3Blue);
    $blueAuto = getAutoValue($team1Blue) + getAutoValue($team2Blue) + getAutoValue($team3Blue);
    $blueEstimate += getAvgPenalties($team1Red) + getAvgPenalties($team2Red) + getAvgPenalties($team3Red);
    $redEstimate += getAvgPenalties($team1Blue) + getAvgPenalties($team2Blue) + getAvgPenalties($team3Blue);
    $redAutoTotal = getAvgUpperGoalT($team1Red) + getAvgUpperGoalT($team2Red) + getAvgUpperGoalT($team3Red);
    $blueAutoTotal = (getAvgUpperGoal($team1Blue) + getAvgUpperGoal($team2Blue) + getAvgUpperGoal($team3Blue));
}
?>

<body>

    <div class="container row-offcanvas row-offcanvas-left">
        <div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">

                <a>
                    <h3><b><u>Match Number:</u></b></h3>
                </a>
                <input type="text" name="match" id="match" size="8" class="form-control">
                <br />
                <button id="submit" class="btn btn-primary" onclick="postwith('');">Submit</button>
                <br />
        </div>
    </div>

    <div class="container row-offcanvas row-offcanvas-left">
        <div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
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