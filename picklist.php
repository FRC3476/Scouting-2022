<html>
<?php
include("header.php") ?>

<head>
    <style>
        body {
            font-size: 12px
        }

        .board {
            margin-left: 500px;
        }

        h1 {
            margin-left: 20px;
            font-size: 2rem;
        }

        .column {
            width: 250px;
            float: left;
            border: solid 4px black;
            height: 100vh;
        }

        .portlet {
            margin: 0 1em 1em 0;
            padding: 0.3em;
        }

        .portlet-header {
            padding: 0.2em 0.3em;
            margin-bottom: 0.5em;
            position: relative;
        }

        .portlet-toggle {
            position: absolute;
            top: 50%;
            right: 0;
            margin-top: -8px;
        }

        .portlet-content {
            padding: 0.4em;
        }

        .portlet-placeholder {
            border: 1px dotted black;
            margin: 0 1em 1em 0;
            height: 50px;
        }
    </style>
</head>

<body>
    <?php include("navBar.php") ?>

    <div class="container">
        <div class="row row-cols-4">
            <div class="col">
                <h3 style="text-align:center">All Teams</h3>
                <div class='row'>
                    <div class='card mb-3' style='max-width: 550px; margin-top: 25px'>
                        <div class='row'>
                            <div class='col-md-4'>
                                <img src='images/Logo.png' class='img-fluid rounded-start' style='max-height: 100px; max-width: 100px; padding: 15px;' alt='...'>
                            </div>
                            <div class='col-md-8'>
                                <div class='card-body'>
                                    <h3 class='card-title'>" . $teamNumber . "</h3>
                                    <h3 class='card-text'>Rank: " . $picklist . "</h3>
                                    <h3 class='card-text'># of Climbs: " . $avgClimb . "</h3>
                                    <h3 class='card-text'>Defense?: " . $totalDefense . "</h3>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <h3 style="text-align:center">Offense</h3>
                <div class='row'>
                    <div class='card mb-3' style='max-width: 550px; margin-top: 25px'>
                        <div class='row'>
                            <div class='col-md-4'>
                                <img src='images/Logo.png' class='img-fluid rounded-start' style='max-height: 100px; max-width: 100px; padding: 15px;' alt='...'>
                            </div>
                            <div class='col-md-8'>
                                <div class='card-body'>
                                    <h3 class='card-title'>" . $teamNumber . "</h3>
                                    <h3 class='card-text'>Rank: " . $picklist . "</h3>
                                    <h3 class='card-text'># of Climbs: " . $avgClimb . "</h3>
                                    <h3 class='card-text'>Defense?: " . $totalDefense . "</h3>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <h3 style="text-align:center">Defense</h3>
                <div class='row'>
                    <div class='card mb-3' style='max-width: 550px; margin-top: 25px'>
                        <div class='row'>
                            <div class='col-md-4'>
                                <img src='images/Logo.png' class='img-fluid rounded-start' style='max-height: 100px; max-width: 100px; padding: 15px;' alt='...'>
                            </div>
                            <div class='col-md-8'>
                                <div class='card-body'>
                                    <h3 class='card-title'>" . $teamNumber . "</h3>
                                    <h3 class='card-text'>Rank: " . $picklist . "</h3>
                                    <h3 class='card-text'># of Climbs: " . $avgClimb . "</h3>
                                    <h3 class='card-text'>Defense?: " . $totalDefense . "</h3>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <h3 style="text-align:center">DNP</h3>
                <div class='row'>
                    <div class='card mb-3' style='max-width: 550px; margin-top: 25px'>
                        <div class='row'>
                            <div class='col-md-4'>
                                <img src='images/Logo.png' class='img-fluid rounded-start' style='max-height: 100px; max-width: 100px; padding: 15px;' alt='...'>
                            </div>
                            <div class='col-md-8'>
                                <div class='card-body'>
                                    <h3 class='card-title'>" . $teamNumber . "</h3>
                                    <h3 class='card-text'>Rank: " . $picklist . "</h3>
                                    <h3 class='card-text'># of Climbs: " . $avgClimb . "</h3>
                                    <h3 class='card-text'>Defense?: " . $totalDefense . "</h3>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <table class="sortable table table-hover" id="RawData" border="1">
        <tr>
            <th>Team Number</th>
            <th>Weighted Score</th>
            <th>Avg Upper Shot Percentage</th>
            <th>Avg Teleop Upper Goal</th>
            <th>Avg Teleop Lower Goal</th>
            <th>Avg Auto Upper Goal</th>
            <th>Avg Auto Lower Goal</th>
            <th>Avg Drive Rank</th>
            <th>Max Teleop Upper Goal</th>
            <th>Max Teleop Lower Goal</th>
            <th>Max Auto Upper Goal</th>
            <th>Max Auto Lower Goal</th>
            <th>Avg Climb</th>
            <th>Total Defense</th>
            <th>TBA OPR</th>
            <th>TBA DPR</th>

        </tr>
        <?php
        include("databaseLibrary.php");
        $teamList = getTeamList();
        foreach ($teamList as $teamNumber) {

            $i = 0;
            $picklist = (getPickList($teamNumber) - getAvgDriveRank($teamNumber));
            $UpperShotPercentage = getAvgUpperShotPercentage($teamNumber);
            $avgTeleopUpper = getAvgUpperGoalT($teamNumber);
            $avgTeleopLower = getAvgLowerGoalT($teamNumber);
            $avgAutoUpper = getAvgUpperGoal($teamNumber);
            $avgAutoLower = getAvgLowerGoal($teamNumber);
            $avgDriveRank = getAvgDriveRank($teamNumber);
            $maxTeleopUpper = getMaxUpperGoalT($teamNumber);
            $maxTeleopLower = getMaxLowerGoalT($teamNumber);
            $maxAutoUpper = getMaxUpperGoal($teamNumber);
            $maxAutoLower = getMaxLowerGoal($teamNumber);
            $avgClimb = getAvgClimb($teamNumber);
            $totalDefense = getTotalDefense($teamNumber);
            $OPR = getOPR($teamNumber);
            $DPR = getDPR($teamNumber);




            echo ("<tr>
					<td><a href='matchStrategy.php?team=" . $teamNumber . "'>" . $teamNumber . "</a></td>
					<th>" . $picklist . "</th>
					<th>" . $UpperShotPercentage . "</th>
					<th>" . round($avgTeleopUpper, 3) . "</th>
					<th>" . round($avgTeleopLower, 3) . "</th>
					<th>" . round($avgAutoUpper, 3) . "</th>
					<th>" . round($avgAutoLower, 3) . "</th>
					<th>" . round($avgDriveRank, 3) . "</th>
					<th>" . $maxTeleopUpper . "</th>
					<th>" . $maxTeleopLower . "</th>
					<th>" . $maxAutoUpper . "</th>
					<th>" . $maxAutoLower . "</th>
					<th>" . round($avgClimb, 3) . "</th>
					<th>" . $totalDefense . "</th>
					<th>" . round($OPR, 3) . "</th>
					<th>" . round($DPR, 3) . "</th>
					</tr>
                    
                    ");

            echo ("
                    <div class='row'>
                        <div class='card mb-3' style='max-width: 550px; justify-content: center'>
                            <div class='row g-0'>
                                <div class='col-md-4'>
                                    <img src='images/Logo.png' class='img-fluid rounded-start' style='max-height: 200px; max-width: 200px; padding: 15px;' alt='...'>
                                </div>
                                <div class='col-md-8'>
                                    <div class='card-body'>
                                        <h3 class='card-title'>" . $teamNumber . "</h3>
                                        <h3 class='card-text'>Rank: " . $picklist . "</h3>
                                        <h3 class='card-text'># of Climbs: " . $avgClimb . "</h3>
                                        <h3 class='card-text'>Defense?: " . $totalDefense . "</h3>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ");
        }

        ?>
    </table>

    </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<?php include("footer.php") ?>