<html>
<?php
include("header.php");
include("navBar.php");
?>
<script src="js/bootstrap.min.js"></script>

<head>

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-material-design-master/dist/css/ripples.min.css" rel="stylesheet">
    <link href="bootstrap-material-design-master/dist/css/material-wfont.min.css" rel="stylesheet">
    <link href="css/bootstrap-material-design.min.css" rel="stylesheet">

    <script src="jquery-1.11.2.min.js"></script>
    <script src="sorttable.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">


</head>

<script src="js/Chart.js"></script>
<style>
    body {
        padding: 0;
        margin: 0;
    }

    #canvas-holder {
        width: 50%;
    }

    #canvas-holder2 {
        width: 50%;
    }

    #canvas-holder3 {
        width: 50%;
    }

    .rotate090 {

        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        transform: rotate(90deg);
    }
</style>
<script>
    var $ = jQuery.noConflict();
</script>

<script>
    function postwith(to) {

        var myForm = document.createElement("form");
        myForm.method = "post";
        myForm.action = to;

        var names = [
            'team1',
            'team2'
        ];

        var nums = [
            document.getElementById('team1').value,
            document.getElementById('team2').value
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

function filter($str)
{
    return filter_var($str, FILTER_UNSAFE_RAW);
}

if (isset($_POST['team1']) && isset($_POST['team2'])) {
    include("databaseLibrary.php");
    $team1 = filter($_POST['team1']);
    $team2 = filter($_POST['team2']);
    $teamNumber = filter($_POST["team1"]);
    $teamNumber2 = filter($_POST["team2"]);
    $teamData = getTeamData($teamNumber);
    $teamData2 = getTeamData($teamNumber2);
}
?>

<body>

    <div class="container row-offcanvas row-offcanvas-left">
        <div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">

            <a>
                <h2><b><u>Team Comparison</u></b></h2>
            </a>
            <div class="row" style="text-align: center;">
                <div class="col-md-2">
                    Team 1:
                    <input type="text" name="team1" id="team1" size="8" class="form-control">
                </div>
                <div class="col-md-2">
                    Team 2:
                    <input type="text" name="team2" id="team2" size="8" class="form-control">
                </div>
            </div>
            <button id="submit" class="btn btn-primary" onclick="postwith('');">Submit Data</button>
        </div>
    </div>


    <div class="container row-offcanvas row-offcanvas-left">
        <div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
            <div class="row">
                <div class="col-md-6">
                    <h1> Team <?php echo ($_POST["team1"]); ?> - <?php echo ($teamData[1]); ?></h1>
                    <div class="box">
                        <div id="myCarousel" class="carousel slide" data-interval="false">
                            <ol class="carousel-indicators">
                                <?php
                                $index = 0;
                                while (file_exists("uploads/" . $_POST["team1"] . "-" . $index . ".jpg") == 1) {
                                    if ($index == 0) {
                                        echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '" class="active"></li>');
                                    } else {
                                        echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '"></li>');
                                    }
                                    $index++;
                                }

                                $index = 0;
                                while (file_exists("uploads/" . $_POST["team1"] . "-" . $index . ".png") == 1) {
                                    if ($index == 0) {
                                        echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '" class="active"></li>');
                                    } else {
                                        echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '"></li>');
                                    }
                                    $index++;
                                }

                                $index = 0;
                                while (file_exists("uploads/" . $_POST["team1"] . "-" . $index . ".jpeg") == 1) {
                                    if ($index == 0) {
                                        echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '" class="active"></li>');
                                    } else {
                                        echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '"></li>');
                                    }
                                    $index++;
                                }
                                ?>
                            </ol>
                            <div class="carousel-inner" role="listbox">
                                <?php
                                $index = 0;
                                while (file_exists("uploads/" . $_POST["team1"] . "-" . $index . ".jpg") == 1) {
                                    if ($index == 0) {
                                        echo ('<div class="item active" >
													<img   id="' . $_POST["team1"] . '-' . $index . '" src="uploads/' . $_POST["team1"] . '-' . $index . '.jpg" >
												</div>');
                                    } else {
                                        echo ('<div class="item" >
													<img   id="' . $_POST["team1"] . '-' . $index . '" src="uploads/' . $_POST["team1"] . '-' . $index . '.jpg" >
												</div>');
                                    }
                                    $index++;
                                }

                                $index = 0;
                                while (file_exists("uploads/" . $_POST["team1"] . "-" . $index . ".png") == 1) {
                                    if ($index == 0) {
                                        echo ('<div class="item active" >
													<img   id="' . $_POST["team1"] . '-' . $index . '" src="uploads/' . $_POST["team1"] . '-' . $index . '.png" >
												</div>');
                                    } else {
                                        echo ('<div class="item" >
													<img   id="' . $_POST["team1"] . '-' . $index . '" src="uploads/' . $_POST["team1"] . '-' . $index . '.png" >
												</div>');
                                    }
                                    $index++;
                                }

                                $index = 0;
                                while (file_exists("uploads/" . $_POST["team1"] . "-" . $index . ".jpeg") == 1) {
                                    if ($index == 0) {
                                        echo ('<div class="item active" >
													<img   id="' . $_POST["team1"] . '-' . $index . '" src="uploads/' . $_POST["team1"] . '-' . $index . '.jpeg" >
												</div>');
                                    } else {
                                        echo ('<div class="item" >
													<img   id="' . $_POST["team1"] . '-' . $index . '" src="uploads/' . $_POST["team1"] . '-' . $index . '.jpeg" >
												</div>');
                                    }
                                    $index++;
                                }
                                ?>
                            </div>
                            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <button class=" btn btn-material-purple">Auto Upper Made</button>
                    <button class=" btn btn-material-red">Auto Lower Made</button>
                    <button class=" btn btn-material-green">Teleop Upper Made</button>
                    <button class=" btn btn-material-blue">Teleop Lower Made</button>
                    <button class=" btn btn-material-orange">Climb</button>




                    <canvas id="dataChart" width="300" height="250"></canvas>
                    <script>
                        var randomScalingFactor = function() {
                            return Math.round(Math.random() * 100)
                        };
                        var lineChartData = {
                            labels: <?php echo (json_encode(matchNum($teamNumber))); ?>,
                            datasets: [

                                {
                                    label: "Auto Upper Goal",
                                    fillColor: "rgba(220,220,220,0.1)",
                                    strokeColor: "purple",
                                    pointColor: "rgba(146, 16, 222,1)",
                                    pointStrokeColor: "#ffff00",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo (json_encode(getAutoUpperGoal($teamNumber))); ?>
                                },

                                {
                                    label: "Auto Lower Goal",
                                    fillColor: "rgba(220,220,220,0.1)",
                                    strokeColor: "red",
                                    pointColor: "rgba(219, 20, 20,1)",
                                    pointStrokeColor: "#ffff00",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo (json_encode(getAutoLowerGoal($teamNumber))); ?>
                                },

                                {
                                    label: "Teleop Upper Goal Made",
                                    fillColor: "rgba(220,220,220,0.1)",
                                    strokeColor: "green",
                                    pointColor: "rgba(16, 224, 19,1)",
                                    pointStrokeColor: "#ffff00",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo (json_encode(getTeleopUpperGoal($teamNumber))); ?>
                                },

                                {
                                    label: "Teleop Lower Goal",
                                    fillColor: "rgba(220,220,220,0.1)",
                                    strokeColor: "blue",
                                    pointColor: "rgba(44, 130, 201, 1)",
                                    pointStrokeColor: "#ffff00",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo (json_encode(getTeleopLowerGoal($teamNumber))); ?>
                                },

                                {
                                    label: "Climb",
                                    fillColor: "rgba(220,220,220,0.1)",
                                    strokeColor: "orange",
                                    pointColor: "rgba(222, 137, 18,1)",
                                    pointStrokeColor: "#ffff00",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo (json_encode(getClimb($teamNumber))); ?>
                                },

                            ]
                        }

                        var ctx = document.getElementById("dataChart").getContext("2d");
                        window.myLine = new Chart(ctx).Line(lineChartData, {
                            responsive: true
                        });
                    </script>

                    <canvas id="myCanvas" width="500" height="250" style="border:1px solid #d3d3d3;"></canvas>
                    <script type="text/javascript">
                        var canvas = document.getElementById('myCanvas');
                        var context = canvas.getContext('2d');
                        var drawLine = false;
                        var oldCoor = {};
                        var i = 1;
                        var t;
                        var coordinateList = [];
                        var lastCoordinate = {};
                        var imageObj = new Image();
                        var matchToPoints = [];
                        var matchToPoints1 = [];
                        var matchToPoints4 = [];
                        var matchToPoints5 = [];
                        var matchToPoints6 = [];
                        var dataList = [];
                        <?php

                        for ($i = 0; $i != sizeof($teamData[8]); $i++) {
                            echo ("matchToPoints[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][25] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamData[8]); $i++) {
                            echo ("matchToPoints4[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][11] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamData[8]); $i++) {
                            echo ("matchToPoints5[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][12] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamData[8]); $i++) {
                            echo ("matchToPoints6[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][13] . ";");
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
                            printTeleop3();
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

                        function drawPoint() {
                            makeCanvasReady();
                            var matchNumber = document.getElementById("matchNum").value;
                            var a = matchToPoints[matchNumber];
                            var b = matchToPoints4[matchNumber];
                            var c = matchToPoints5[matchNumber];
                            var d = matchToPoints6[matchNumber];
                            for (var i = 0; i != a.length; i++) {
                                if (((b / (b + c)) >= 0.9)) {
                                    context.fillStyle = "#3cff00";
                                    console.log((a[i][0]));
                                    context.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                } else if (((b / (b + c)) >= 0.5)) {
                                    context.fillStyle = "#fff200";
                                    context.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                } else if (((b / (b + c)) >= 0.3)) {
                                    context.fillStyle = "#ff9100";
                                    context.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                } else if (((b / (b + c)) >= 0)) {
                                    context.fillStyle = "#ff0000";
                                    context.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                } else if (b + c == 0) {
                                    context.fillStyle = "#000000";
                                    context.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                }
                            }
                        }

                        function drawPoint4() {
                            makeCanvasReady();
                            for (var j = 0; j != 200; j++) {
                                var a = matchToPoints[j];
                                var b = matchToPoints4[j];
                                var c = matchToPoints5[j];
                                var d = matchToPoints6[j];
                                if (a != null) {
                                    for (var i = 0; i != a.length; i++) {
                                        if (((b / (b + c)) >= 0.9)) {
                                            context.fillStyle = "#3cff00";
                                            console.log((a[i][0]));
                                            context.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                        } else if (((b / (b + c)) >= 0.5)) {
                                            context.fillStyle = "#fff200";
                                            context.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                        } else if (((b / (b + c)) >= 0.3)) {
                                            context.fillStyle = "#ff9100";
                                            context.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                        } else if (((b / (b + c)) >= 0)) {
                                            context.fillStyle = "#ff0000";
                                            context.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                        } else if (b + c == 0) {
                                            context.fillStyle = "#000000";
                                            context.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                        }
                                    }
                                } else {
                                    continue;
                                    console.log("fail");
                                }
                            }
                        }

                        function printTeleop4() {
                            var matchNumber = document.getElementById("matchNum").value;
                            var b = matchToPoints4[matchNumber];
                            var c = matchToPoints5[matchNumber];
                            var d = matchToPoints6[matchNumber];
                            if (b != null) {
                                console.log("Teleop Upper Made: " + b + ", Teleop Upper Miss: " + c + ", Teleop Lower Goal: " + d);
                                document.getElementById('teleop5').innerHTML = "Teleop Upper Made: " + b;
                                document.getElementById('teleop6').innerHTML = "Teleop Upper Miss: " + c;
                                document.getElementById('teleop7').innerHTML = "Teleop Lower Made: " + d;
                            }
                        }

                        function printTeleop3() {
                            document.getElementById('teleop5').innerHTML = "";
                            document.getElementById('teleop6').innerHTML = "";
                            document.getElementById('teleop7').innerHTML = "";
                        }
                    </script>

                    <h4><b>Match Number -</b></h4>
                    <select onclick="drawPoint(); printTeleop4();" id="matchNum" class="form-control">
                        <?php

                        for ($i = 0; $i != sizeof($teamData[8]); $i++) {
                            echo ("<option value='" . $teamData[8][$i][2] . "'>" . $teamData[8][$i][2] . "</option>");
                        }

                        ?>
                    </select>
                    <div>
                        <button type="button" onClick="drawPoint4(); printTeleop3();" class=" btn btn-material-orange" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> Show All </button>
                    </div>
                    <div>
                        <span id='teleop5'></span>
                    </div>
                    <div>
                        <span id='teleop6'></span>
                    </div>
                    <div>
                        <span id='teleop7'></span>
                    </div>
                    <a>
                        <h3><b><u>Statistics:</u></b></h3>
                    </a>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr class="danger">
                                    <td>ELO</td>
                                    <td><?php echo (getElo($teamNumber)); ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Average Auto Upper Goal</td>
                                    <td><?php echo (getAvgUpperGoal($teamNumber)); ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Average Auto Lower Goal</td>
                                    <td><?php echo (getAvgLowerGoal($teamNumber)); ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Average Teleop Upper Goal</td>
                                    <td><?php echo (getAvgUpperGoalT($teamNumber)); ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Average Teleop Lower Goal</td>
                                    <td><?php echo (getAvgLowerGoalT($teamNumber)); ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Average Cycle Count</td>
                                    <td><?php echo (getAvgCycleCount($teamNumber)); ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Upper Shot Percentage</td>
                                    <td><?php echo (getAvgUpperShotPercentage($teamNumber)); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a>
                        <h3><b><u>Comments</u></b></h3>
                    </a>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr class="success">
                                    <td>Match Strategy Comments</td>
                                    <td><?php $mc = matchComments($teamNumber);
                                        for ($i = 0; $i != sizeof($mc); $i++) {
                                            echo ("$mc[$i].") . PHP_EOL;
                                        } ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Defense Comments</td>
                                    <td><?php $dc = defenseComments($teamNumber);
                                        for ($i = 0; $i != sizeof($dc); $i++) {
                                            echo ("$dc[$i].") . PHP_EOL;
                                        } ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>DNP</td>
                                    <td><?php echo (getTotalDNP($teamNumber)); ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Average Penalties</td>
                                    <td><?php echo (getAvgPenalties($teamNumber)); ?></td>
                                </tr>

                                <tr class="info">
                                    <td>Avg Alliance Ranking</td>
                                    <td><?php echo (getAvgDriveRank($teamNumber)); ?></td>
                                </tr>

                                <tr class="danger">
                                    <td>Total Defense</td>
                                    <td><?php echo (getTotalDefense($teamNumber)); ?></td>
                                </tr>

                            </tbody>
                        </table>

                    </div>

                    <a>
                        <h3><b><u>Climb Statistics:</u></b></h3>
                    </a>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr class="info">
                                    <td>Average Climbs</td>
                                    <td><?php echo (getAvgClimb($teamNumber)); ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Total Climbs</td>
                                    <td><?php echo (getTotalClimb($teamNumber)); ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Total Low Climbs</td>
                                    <td><?php echo (getTotalSingleClimb($teamNumber)); ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Total Med Climbs</td>
                                    <td><?php echo (getTotalDoubleClimb($teamNumber)); ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Total High Climbs</td>
                                    <td><?php echo (getTotalTripleClimb($teamNumber)); ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Total Traversal Climbs</td>
                                    <td><?php echo (getTotalQuadClimb($teamNumber)); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <a>
                        <h3><b><u>Pit Statistics:</u></b></h3>
                    </a>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr class="danger">
                                    <td>No. of Batteries</td>
                                    <td><?php echo ($teamData[2]); ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Locktighted Falcolns?</td>
                                    <td><?php echo ($teamData[3]); ?></td>
                                </tr>

                                <tr class="success">
                                    <td>Code Language</td>
                                    <td><?php echo ($teamData[4]); ?></td>
                                </tr>

                                <tr class="danger">
                                    <td>Auto Path and Pit Comments</td>
                                    <td><?php echo ($teamData[5]); ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Have a Climber</td>
                                    <td><?php echo ($teamData[6]); ?></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="col-md-6">
                    <h1> Team <?php echo ($_POST["team2"]); ?> - <?php echo ($teamData2[1]); ?></h1>
                    <div class="box">
                        <div id="myCarousel" class="carousel slide" data-interval="false">
                            <ol class="carousel-indicators">
                                <?php
                                $index = 0;
                                while (file_exists("uploads/" . $_POST["team2"] . "-" . $index . ".jpg") == 1) {
                                    if ($index == 0) {
                                        echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '" class="active"></li>');
                                    } else {
                                        echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '"></li>');
                                    }
                                    $index++;
                                }

                                $index = 0;
                                while (file_exists("uploads/" . $_POST["team2"] . "-" . $index . ".png") == 1) {
                                    if ($index == 0) {
                                        echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '" class="active"></li>');
                                    } else {
                                        echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '"></li>');
                                    }
                                    $index++;
                                }

                                $index = 0;
                                while (file_exists("uploads/" . $_POST["team2"] . "-" . $index . ".jpeg") == 1) {
                                    if ($index == 0) {
                                        echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '" class="active"></li>');
                                    } else {
                                        echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '"></li>');
                                    }
                                    $index++;
                                }
                                ?>
                            </ol>
                            <div class="carousel-inner" role="listbox">
                                <?php
                                $index = 0;
                                while (file_exists("uploads/" . $_POST["team2"] . "-" . $index . ".jpg") == 1) {
                                    if ($index == 0) {
                                        echo ('<div class="item active" >
													<img   id="' . $_POST["team2"] . '-' . $index . '" src="uploads/' . $_POST["team2"] . '-' . $index . '.jpg" >
												</div>');
                                    } else {
                                        echo ('<div class="item" >
													<img   id="' . $_POST["team2"] . '-' . $index . '" src="uploads/' . $_POST["team2"] . '-' . $index . '.jpg" >
												</div>');
                                    }
                                    $index++;
                                }

                                $index = 0;
                                while (file_exists("uploads/" . $_POST["team2"] . "-" . $index . ".png") == 1) {
                                    if ($index == 0) {
                                        echo ('<div class="item active" >
													<img   id="' . $_POST["team2"] . '-' . $index . '" src="uploads/' . $_POST["team2"] . '-' . $index . '.png" >
												</div>');
                                    } else {
                                        echo ('<div class="item" >
													<img   id="' . $_POST["team2"] . '-' . $index . '" src="uploads/' . $_POST["team2"] . '-' . $index . '.png" >
												</div>');
                                    }
                                    $index++;
                                }

                                $index = 0;
                                while (file_exists("uploads/" . $_POST["team2"] . "-" . $index . ".jpeg") == 1) {
                                    if ($index == 0) {
                                        echo ('<div class="item active" >
													<img   id="' . $_POST["team2"] . '-' . $index . '" src="uploads/' . $_POST["team2"] . '-' . $index . '.jpeg" >
												</div>');
                                    } else {
                                        echo ('<div class="item" >
													<img   id="' . $_POST["team2"] . '-' . $index . '" src="uploads/' . $_POST["team2"] . '-' . $index . '.jpeg" >
												</div>');
                                    }
                                    $index++;
                                }
                                ?>
                            </div>
                            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <button class=" btn btn-material-purple">Auto Upper Made</button>
                    <button class=" btn btn-material-red">Auto Lower Made</button>
                    <button class=" btn btn-material-green">Teleop Upper Made</button>
                    <button class=" btn btn-material-blue">Teleop Lower Made</button>
                    <button class=" btn btn-material-orange">Climb</button>




                    <canvas id="dataChart2" width="300" height="250"></canvas>
                    <script>
                        var randomScalingFactor = function() {
                            return Math.round(Math.random() * 100)
                        };
                        var lineChartData1 = {
                            labels: <?php echo (json_encode(matchNum($teamNumber2))); ?>,
                            datasets: [

                                {
                                    label: "Auto Upper Goal",
                                    fillColor: "rgba(220,220,220,0.1)",
                                    strokeColor: "purple",
                                    pointColor: "rgba(146, 16, 222,1)",
                                    pointStrokeColor: "#ffff00",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo (json_encode(getAutoUpperGoal($teamNumber2))); ?>
                                },

                                {
                                    label: "Auto Lower Goal",
                                    fillColor: "rgba(220,220,220,0.1)",
                                    strokeColor: "red",
                                    pointColor: "rgba(219, 20, 20,1)",
                                    pointStrokeColor: "#ffff00",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo (json_encode(getAutoLowerGoal($teamNumber2))); ?>
                                },

                                {
                                    label: "Teleop Upper Goal Made",
                                    fillColor: "rgba(220,220,220,0.1)",
                                    strokeColor: "green",
                                    pointColor: "rgba(16, 224, 19,1)",
                                    pointStrokeColor: "#ffff00",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo (json_encode(getTeleopUpperGoal($teamNumber2))); ?>
                                },


                                {
                                    label: "Teleop Lower Goal",
                                    fillColor: "rgba(220,220,220,0.1)",
                                    strokeColor: "blue",
                                    pointColor: "rgba(44, 130, 201, 1)",
                                    pointStrokeColor: "#ffff00",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo (json_encode(getTeleopLowerGoal($teamNumber2))); ?>
                                },

                                {
                                    label: "Climb",
                                    fillColor: "rgba(220,220,220,0.1)",
                                    strokeColor: "orange",
                                    pointColor: "rgba(222, 137, 18,1)",
                                    pointStrokeColor: "#ffff00",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo (json_encode(getClimb($teamNumber2))); ?>
                                },

                            ]
                        }

                        var ctx1 = document.getElementById("dataChart2").getContext("2d");
                        window.myLine = new Chart(ctx1).Line(lineChartData1, {
                            responsive: true
                        });
                    </script>
                    <canvas id="myCanvas2" width="500" height="250" style="border:1px solid #d3d3d3;"></canvas>
                    <script type="text/javascript">
                        var canvas2 = document.getElementById('myCanvas2');
                        var context2 = canvas2.getContext('2d');
                        var drawLine2 = false;
                        var oldCoor2 = {};
                        var i = 1;
                        var t;
                        var coordinateList2 = [];
                        var lastCoordinate2 = {};
                        var imageObj2 = new Image();
                        var matchToPoints2 = [];
                        var matchToPoints3 = [];
                        var matchToPoints7 = [];
                        var matchToPoints8 = [];
                        var matchToPoints9 = [];
                        var dataList = [];
                        <?php

                        for ($i = 0; $i != sizeof($teamData2[8]); $i++) {
                            echo ("matchToPoints2[" . $teamData2[8][$i][2] . "] = " . $teamData2[8][$i][25] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamData2[8]); $i++) {
                            echo ("matchToPoints7[" . $teamData2[8][$i][2] . "] = " . $teamData2[8][$i][11] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamData2[8]); $i++) {
                            echo ("matchToPoints8[" . $teamData2[8][$i][2] . "] = " . $teamData2[8][$i][12] . ";");
                        }
                        for ($i = 0; $i != sizeof($teamData2[8]); $i++) {
                            echo ("matchToPoints9[" . $teamData2[8][$i][2] . "] = " . $teamData2[8][$i][13] . ";");
                        }

                        ?>
                        <?php


                        for ($i = 0; $i != sizeof($teamData2[8]); $i++) {
                            $a += ('' . $teamData2[8][$i][2] . ',');
                        }
                        $a = substr($a, 0, -2);

                        ?>
                        imageObj2.onload = function() {
                            makeCanvasReady2();
                            drawPoint3();
                            printTeleop1();
                            var ctx2 = document.getElementById("dataChart3").getContext("2d");
                            window.myLine = new Chart(ctx2).Line(lineChartData, {
                                responsive: true
                            });
                        };
                        imageObj2.src = 'images/field.png';

                        function makeCanvasReady2() {
                            context2.clearRect(0, 0, 500, 250);
                            context2.drawImage(imageObj2, 0, 0, 500, 250);
                            console.log("hi");
                        }

                        function drawPoint2() {
                            makeCanvasReady2();
                            var matchNumber2 = document.getElementById("matchNum2").value;
                            var a = matchToPoints2[matchNumber2];
                            var b = matchToPoints7[matchNumber2];
                            var c = matchToPoints8[matchNumber2];
                            var d = matchToPoints9[matchNumber2];
                            for (var i = 0; i != a.length; i++) {
                                if (((b / (b + c)) >= 0.9)) {
                                    context2.fillStyle = "#3cff00";
                                    console.log((a[i][0]));
                                    context2.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                } else if (((b / (b + c)) >= 0.5)) {
                                    context2.fillStyle = "#fff200";
                                    context2.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                } else if (((b / (b + c)) >= 0.3)) {
                                    context2.fillStyle = "#ff9100";
                                    context2.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                } else if (((b / (b + c)) >= 0)) {
                                    context2.fillStyle = "#ff0000";
                                    context2.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                } else if (b + c == 0) {
                                    context2.fillStyle = "#000000";
                                    context2.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                }
                            }
                        }

                        function drawPoint3() {
                            makeCanvasReady2();
                            for (var j = 0; j != 200; j++) {
                                var a = matchToPoints2[j];
                                var b = matchToPoints7[j];
                                var c = matchToPoints8[j];
                                var d = matchToPoints9[j];
                                if (a != null) {
                                    for (var i = 0; i != a.length; i++) {
                                        if (((b / (b + c)) >= 0.9)) {
                                            context2.fillStyle = "#3cff00";
                                            console.log((a[i][0]));
                                            context2.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                        } else if (((b / (b + c)) >= 0.5)) {
                                            context2.fillStyle = "#fff200";
                                            context2.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                        } else if (((b / (b + c)) >= 0.3)) {
                                            context2.fillStyle = "#ff9100";
                                            context2.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                        } else if (((b / (b + c)) >= 0)) {
                                            context2.fillStyle = "#ff0000";
                                            context2.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                        } else if (b + c == 0) {
                                            context2.fillStyle = "#000000";
                                            context2.fillRect((5 / 7) * (a[i][0]), (5 / 7) * (a[i][1]), 5, 5);
                                        }
                                    }
                                } else {
                                    continue;
                                    console.log("fail");
                                }
                            }
                        }

                        function printTeleop() {
                            var matchNumber2 = document.getElementById("matchNum2").value;
                            var b = matchToPoints7[matchNumber2];
                            var c = matchToPoints8[matchNumber2];
                            var d = matchToPoints9[matchNumber2];
                            if (b != null) {
                                console.log("Teleop Upper Made: " + b + ", Teleop Upper Miss: " + c + ", Teleop Lower Goal: " + d);
                                document.getElementById('teleop').innerHTML = "Teleop Upper Made: " + b;
                                document.getElementById('teleop2').innerHTML = "Teleop Upper Miss: " + c;
                                document.getElementById('teleop3').innerHTML = "Teleop Lower Made: " + d;
                            }
                        }

                        function printTeleop1() {
                            document.getElementById('teleop').innerHTML = "";
                            document.getElementById('teleop2').innerHTML = "";
                            document.getElementById('teleop3').innerHTML = "";
                        }
                    </script>

                    <h4><b>Match Number -</b></h4>
                    <select onclick="drawPoint2(); printTeleop();" id="matchNum2" class="form-control">
                        <?php

                        for ($i = 0; $i != sizeof($teamData2[8]); $i++) {
                            echo ("<option value='" . $teamData2[8][$i][2] . "'>" . $teamData2[8][$i][2] . "</option>");
                        }

                        ?>
                    </select>
                    <div>
                        <button type="button" onClick="drawPoint3(); printTeleop1();" class=" btn btn-material-orange" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> Show All </button>
                    </div>
                    <div>
                        <span id='teleop'></span>
                    </div>
                    <div>
                        <span id='teleop2'></span>
                    </div>
                    <div>
                        <span id='teleop3'></span>
                    </div>
                    <a>
                        <h3><b><u>Statistics:</u></b></h3>
                    </a>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr class="danger">
                                    <td>ELO</td>
                                    <td><?php echo (getElo($teamNumber2)); ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Average Auto Upper Goal</td>
                                    <td><?php echo (getAvgUpperGoal($teamNumber2)); ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Average Auto Lower Goal</td>
                                    <td><?php echo (getAvgLowerGoal($teamNumber2)); ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Average Teleop Upper Goal</td>
                                    <td><?php echo (getAvgUpperGoalT($teamNumber2)); ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Average Teleop Lower Goal</td>
                                    <td><?php echo (getAvgLowerGoalT($teamNumber2)); ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Average Cycle Count</td>
                                    <td><?php echo (getAvgCycleCount($teamNumber2)); ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Upper Shot Percentage</td>
                                    <td><?php echo (getAvgUpperShotPercentage($teamNumber2)); ?></td>
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                    <a>
                        <h3><b><u>Comments</u></b></h3>
                    </a>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr class="success">
                                    <td>Match Strategy Comments</td>
                                    <td><?php $mc = matchComments($teamNumber2);
                                        for ($i = 0; $i != sizeof($mc); $i++) {
                                            echo ("$mc[$i].") . PHP_EOL;
                                        } ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Defense Comments</td>
                                    <td><?php $dc = defenseComments($teamNumber2);
                                        for ($i = 0; $i != sizeof($dc); $i++) {
                                            echo ("$dc[$i].") . PHP_EOL;
                                        } ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>DNP</td>
                                    <td><?php echo (getTotalDNP($teamNumber2)); ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Average Penalties</td>
                                    <td><?php echo (getAvgPenalties($teamNumber2)); ?></td>
                                </tr>

                                <tr class="info">
                                    <td>Avg Drive Ranking</td>
                                    <td><?php echo (getAvgDriveRank($teamNumber2)); ?></td>
                                </tr>

                                <tr class="danger">
                                    <td>Total Defense</td>
                                    <td><?php echo (getTotalDefense($teamNumber2)); ?></td>
                                </tr>

                            </tbody>
                        </table>

                    </div>

                    <a>
                        <h3><b><u>Climb Statistics:</u></b></h3>
                    </a>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr class="info">
                                    <td>Average Climbs</td>
                                    <td><?php echo (getAvgClimb($teamNumber2)); ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Total Climbs</td>
                                    <td><?php echo (getTotalClimb($teamNumber2)); ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Total Low Climbs</td>
                                    <td><?php echo (getTotalSingleClimb($teamNumber2)); ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Total Med Climbs</td>
                                    <td><?php echo (getTotalDoubleClimb($teamNumber2)); ?></td>
                                </tr>
                                <tr class="success">
                                    <td>Total High Climbs</td>
                                    <td><?php echo (getTotalTripleClimb($teamNumber2)); ?></td>
                                </tr>
                                <tr class="danger">
                                    <td>Total Traversal Climbs</td>
                                    <td><?php echo (getTotalQuadClimb($teamNumber2)); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <a>
                        <h3><b><u>Pit Statistics:</u></b></h3>
                    </a>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr class="danger">
                                    <td>No. of Batteries</td>
                                    <td><?php echo ($teamData2[2]); ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Locktighted Falcolns?</td>
                                    <td><?php echo ($teamData2[3]); ?></td>
                                </tr>

                                <tr class="success">
                                    <td>Code Language</td>
                                    <td><?php echo ($teamData2[4]); ?></td>
                                </tr>

                                <tr class="danger">
                                    <td>Auto Path and Pit Comments</td>
                                    <td><?php echo ($teamData2[5]); ?></td>
                                </tr>
                                <tr class="info">
                                    <td>Have a Climber</td>
                                    <td><?php echo ($teamData2[6]); ?></td>
                                </tr>

                            </tbody>
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