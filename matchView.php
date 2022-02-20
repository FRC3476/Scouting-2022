<html>
<?php
include("header.php");
include("navBar.php");
?>
<?php
$blueEstimate = 0;
$redEstimate = 0;
function filter($str)
{
    return filter_var($str, FILTER_UNSAFE_RAW);
}
if (
    isset($_POST['team1Blue']) && isset($_POST['team2Blue']) && isset($_POST['team3Blue'])
    && isset($_POST['team1Red']) && isset($_POST['team2Red']) && isset($_POST['team3Red'])
) {
    include("databaseLibrary.php");
    $team1Blue = filter($_POST['team1Blue']);
    $team2Blue = filter($_POST['team2Blue']);
    $team3Blue = filter($_POST['team3Blue']);
    $team1Red = filter($_POST['team1Red']);
    $team2Red = filter($_POST['team2Red']);
    $team3Red = filter($_POST['team3Red']);
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
    $redAutoEst = getAvgUpperGoal($team1Red)+getAvgUpperGoal($team2Red)+getAvgUpperGoal($team3Red)+getAvgLowerGoal($team1Red)+getAvgLowerGoal($team2Red)+getAvgLowerGoal($team3Red);
    if ($redAutoEst >= 8){
        $redAutoEst = 8;
    }
    $blueAutoEst = getAvgUpperGoal($team1Blue)+getAvgUpperGoal($team2Blue)+getAvgUpperGoal($team3Blue)+getAvgLowerGoal($team1Blue)+getAvgLowerGoal($team2Blue)+getAvgLowerGoal($team3Blue);
    if ($blueAutoEst >= 8){
        $blueAutoEst = 8;
    }
    $blueTeleopEst = getAvgUpperGoalT($team1Blue)+getAvgUpperGoalT($team2Blue)+getAvgUpperGoalT($team3Blue)+getAvgLowerGoalT($team1Blue)+getAvgLowerGoalT($team2Blue)+getAvgLowerGoalT($team3Blue);

    $redAuto = getAutoValue($team1Red) + getAutoValue($team2Red) + getAutoValue($team3Red);
    $blueAuto = getAutoValue($team1Blue) + getAutoValue($team2Blue) + getAutoValue($team3Blue);
    $blueEstimate += getAvgPenalties($team1Red) + getAvgPenalties($team2Red) + getAvgPenalties($team3Red);
    $redEstimate += getAvgPenalties($team1Blue) + getAvgPenalties($team2Blue) + getAvgPenalties($team3Blue);
}
?>

<body>

    <div class="container row-offcanvas row-offcanvas-left">
        <a>
            <h3><b><u>Red Alliance:</u></b></h3>
        </a>
        <div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
            <div class="row" style="text-align: center;">
                <div class="col-md-2">
                    Team 1:
                    <input type="text" name="team1Red" id="team1Red" size="8" class="form-control">
                </div>
                <div class="col-md-2">
                    Team 2:
                    <input type="text" name="team2Red" id="team2Red" size="8" class="form-control">
                </div>
                <div class="col-md-2">
                    Team 3:
                    <input type="text" name="team3Red" id="team3Red" size="8" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="container row-offcanvas row-offcanvas-left">
        <a>
            <h3><b><u>Blue Alliance:</u></b></h3>
        </a>
        <div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
            <div class="row" style="text-align: center;">
                <div class="col-md-2">
                    Team 1:
                    <input type="text" name="team1Blue" id="team1Blue" size="8" class="form-control">
                </div>
                <div class="col-md-2">
                    Team 2:
                    <input type="text" name="team2Blue" id="team2Blue" size="8" class="form-control">
                </div>
                <div class="col-md-2">
                    Team 3:
                    <input type="text" name="team3Blue" id="team3Blue" size="8" class="form-control">
                </div>
            </div>
        </div>
        <br />
        <button id="submit" class="btn btn-primary" onclick="postwith('');">Submit Data</button>
        <br />

    </div>

    <div class="container row-offcanvas row-offcanvas-left">
        <div class="row">
            <div class="column1">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr class="danger">
                                <td>Predicted Red Score:</td>
                                <td><?php echo (($redEstimate)); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Robots with Autos</td>
                                <td><?php echo ($redAuto); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Est Auto Upper</td>
                                <td><?php echo (getAvgUpperGoal($team1Red)+getAvgUpperGoal($team2Red)+getAvgUpperGoal($team3Red)); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Est Auto Lower</td>
                                <td><?php echo (getAvgLowerGoal($team1Red)+getAvgLowerGoal($team2Red)+getAvgLowerGoal($team3Red)); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Est Teleop Upper</td>
                                <td><?php echo (getAvgUpperGoalT($team1Red)+getAvgUpperGoalT($team2Red)+getAvgUpperGoalT($team3Red)); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Est Teleop Lower</td>
                                <td><?php echo (getAvgLowerGoalT($team1Red)+getAvgLowerGoalT($team2Red)+getAvgLowerGoalT($team3Red)); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Highest Red 1 Climb</td>
                                <td><?php echo ($red1Climb); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Highest Red 2 Climb</td>
                                <td><?php echo ($red2Climb); ?></td>
                            </tr>
                            <tr class="danger">
                                <td>Highest Red 3 Climb</td>
                                <td><?php echo ($red3Climb); ?></td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="column1">

                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr class="info">
                                <td>Predicted Blue Score:</td>
                                <td><?php echo (($blueEstimate)); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Robots with Autos</td>
                                <td><?php echo ($blueAuto); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Est Auto Upper</td>
                                <td><?php echo (getAvgUpperGoal($team1Blue)+getAvgUpperGoal($team2Blue)+getAvgUpperGoal($team3Blue)); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Est Auto Lower</td>
                                <td><?php echo (getAvgLowerGoal($team1Blue)+getAvgLowerGoal($team2Blue)+getAvgLowerGoal($team3Blue)); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Est Teleop Upper</td>
                                <td><?php echo (getAvgUpperGoalT($team1Blue)+getAvgUpperGoalT($team2Blue)+getAvgUpperGoalT($team3Blue)); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Est Teleop Lower</td>
                                <td><?php echo (getAvgLowerGoalT($team1Blue)+getAvgLowerGoalT($team2Blue)+getAvgLowerGoalT($team3Blue)); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Highest Blue 1 Climb</td>
                                <td><?php echo ($blue1Climb); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Highest Blue 2 Climb</td>
                                <td><?php echo ($blue2Climb); ?></td>
                            </tr>
                            <tr class="info">
                                <td>Highest Blue 3 Climb</td>
                                <td><?php echo ($blue3Climb); ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>


<script>
    function postwith(to) {

        var myForm = document.createElement("form");
        myForm.method = "post";
        myForm.action = to;

        var names = [
            'team1Blue',
            'team2Blue',
            'team3Blue',
            'team1Red',
            'team2Red',
            'team3Red'
        ];

        var nums = [
            document.getElementById('team1Blue').value,
            document.getElementById('team2Blue').value,
            document.getElementById('team3Blue').value,
            document.getElementById('team1Red').value,
            document.getElementById('team2Red').value,
            document.getElementById('team3Red').value
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