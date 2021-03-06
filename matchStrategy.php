<html>
<?php
include("navBar.php"); ?>

<body>
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
    
    tr td{
      font-size: 12px; 
    }
	</style>
	<script>
		var $ = jQuery.noConflict();
	</script>
	<div class="container row-offcanvas row-offcanvas-left">
		<div class="well column  col-lg-112  col-sm-12 col-xs-12" id="content">
			<?php
			if ($_GET["team"]) {
				$teamNumber = $_GET["team"];
				include("databaseName.php");
				include("databaseLibrary.php");
        $leadScoutELO = getLeadScoutELODict();
				$teamData = getTeamData($teamNumber);
			}
      
      
      function dummy_lookup($dict, $k){
        if (isset($dict[$k])){
          return $dict[$k];
        }
        return 0;
      }
      
			?>
			<form action="" method="get">
				Enter Team Number: <input class="control-label" type="number" name="team" id="team" size="10" height="10" width="40">
				<button id="submit" class="btn btn-primary" onclick="">Display</button>
				<div class="row">
					<div class="col-md-4">
						<h1> Team <?php echo ($_GET["team"]); ?> - <?php echo ($teamData[1]); ?></h1>
						<div class="box">
							<div id="myCarousel" class="carousel slide" data-interval="false">
								<ol class="carousel-indicators">
									<?php
									$index = 0;
									while (file_exists("uploads/" . $_GET["team"] . "-" . $index . ".jpg") == 1) {
										if ($index == 0) {
											echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '" class="active"></li>');
										} else {
											echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '"></li>');
										}
										$index++;
									}

									$index = 0;
									while (file_exists("uploads/" . $_GET["team"] . "-" . $index . ".png") == 1) {
										if ($index == 0) {
											echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '" class="active"></li>');
										} else {
											echo ('<li data-target="#myCarousel" data-slide-to="' . $index . '"></li>');
										}
										$index++;
									}

									$index = 0;
									while (file_exists("uploads/" . $_GET["team"] . "-" . $index . ".jpeg") == 1) {
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
									while (file_exists("uploads/" . $_GET["team"] . "-" . $index . ".jpg") == 1) {
										if ($index == 0) {
											echo ('<div class="item active" >
											<img   id="' . $_GET["team"] . '-' . $index . '" src="uploads/' . $_GET["team"] . '-' . $index . '.jpg" >
										 </div>');
										} else {
											echo ('<div class="item" >
											<img   id="' . $_GET["team"] . '-' . $index . '" src="uploads/' . $_GET["team"] . '-' . $index . '.jpg" >
										 </div>');
										}
										$index++;
									}

									$index = 0;
									while (file_exists("uploads/" . $_GET["team"] . "-" . $index . ".png") == 1) {
										if ($index == 0) {
											echo ('<div class="item active" >
											<img   id="' . $_GET["team"] . '-' . $index . '" src="uploads/' . $_GET["team"] . '-' . $index . '.png" >
										 </div>');
										} else {
											echo ('<div class="item" >
											<img   id="' . $_GET["team"] . '-' . $index . '" src="uploads/' . $_GET["team"] . '-' . $index . '.png" >
										 </div>');
										}
										$index++;
									}

									$index = 0;
									while (file_exists("uploads/" . $_GET["team"] . "-" . $index . ".jpeg") == 1) {
										if ($index == 0) {
											echo ('<div class="item active" >
											<img   id="' . $_GET["team"] . '-' . $index . '" src="uploads/' . $_GET["team"] . '-' . $index . '.jpeg" >
										 </div>');
										} else {
											echo ('<div class="item" >
											<img   id="' . $_GET["team"] . '-' . $index . '" src="uploads/' . $_GET["team"] . '-' . $index . '.jpeg" >
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
										label: "Auto Upper",
										fillColor: "rgba(220,220,220,0.1)",
										strokeColor: "purple",
										pointColor: "rgba(146, 16, 222,1)",
										pointStrokeColor: "#ffff00",
										pointHighlightFill: "#fff",
										pointHighlightStroke: "rgba(220,220,220,1)",
										data: <?php echo (json_encode(getAutoUpperGoal($teamNumber))); ?>
									},

									{
										label: "Auto Lower",
										fillColor: "rgba(220,220,220,0.1)",
										strokeColor: "red",
										pointColor: "rgba(219, 20, 20,1)",
										pointStrokeColor: "#ffff00",
										pointHighlightFill: "#fff",
										pointHighlightStroke: "rgba(220,220,220,1)",
										data: <?php echo (json_encode(getAutoLowerGoal($teamNumber))); ?>
									},

									{
										label: "Teleop Upper",
										fillColor: "rgba(220,220,220,0.1)",
										strokeColor: "green",
										pointColor: "rgba(16, 224, 19,1)",
										pointStrokeColor: "#ffff00",
										pointHighlightFill: "#fff",
										pointHighlightStroke: "rgba(220,220,220,1)",
										data: <?php echo (json_encode(getTeleopUpperGoal($teamNumber))); ?>
									},

									{
										label: "Teleop Lower",
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
						</script>


					</div>


					<div class="col-md-7">
						<a>
							<h3><b><u>Auto Path:</u></b></h3>
						</a>
						<div>
							<canvas id="myCanvas" width="600" height="460" style="border:1px solid #d3d3d3;"></canvas>
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
								var matchToPoints4 = [];
								var matchToPoints5 = [];
								var matchToPoints6 = [];
								var matchToPoints7 = [];
								var matchToPoints8 = [];
								var matchToPoints9 = [];
								<?php

								for ($i = 0; $i != sizeof($teamData[8]); $i++) {
									echo ("matchToPoints[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][5] . ";");
								}
								for ($i = 0; $i != sizeof($teamData[8]); $i++) {
									echo ("matchToPoints4[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][7] . ";");
								}
								for ($i = 0; $i != sizeof($teamData[8]); $i++) {
									echo ("matchToPoints6[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][9] . ";");
								}
								for ($i = 0; $i != sizeof($teamData[8]); $i++) {
									echo ("matchToPoints5[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][8] . ";");
								}
								for ($i = 0; $i != sizeof($teamData[8]); $i++) {
									echo ("matchToPoints7[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][11] . ";");
								}
								for ($i = 0; $i != sizeof($teamData[8]); $i++) {
									echo ("matchToPoints8[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][12] . ";");
								}
								for ($i = 0; $i != sizeof($teamData[8]); $i++) {
									echo ("matchToPoints9[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][13] . ";");
								}

								?>
								imageObj.onload = function() {
									makeCanvasReady();
									var ctx = document.getElementById("dataChart").getContext("2d");
									window.myLine = new Chart(ctx).Line(lineChartData, {
										responsive: true
									});
								};
								imageObj.src = 'images/RedField.png';

								function makeCanvasReady() {
									context.clearRect(0, 0, 600, 460);
									context.drawImage(imageObj, 0, 0, 600, 460);
								}

								function adjustCanvas() {
									$("#canvasHolder").css('height', $(window).height() - 25);
									$("#canvasHolder").css('height', $(window).height() - 25);
									$("#main").attr('width', $("#canvasHolder").width());
									$("#main").attr('height', $("#canvasHolder").height());
								}

								function drawPoint(context, x, y) {
									context.fillRect(x, y, 1, 1);
								}

								function drawPointLines() {
									makeCanvasReady();
									var matchNumber = document.getElementById("matchNum").value;
									var a = matchToPoints[matchNumber];
									var color = "#FFFFFF";
									context.beginPath();
									context.strokeStyle = color;

									for (var i = 0; i != a.length; i++) {
										if (i == 0) {
											context.moveTo((a[i][0]), (a[i][1]));
										} else {
											context.lineTo((a[i][0]), (a[i][1]));
										}
									}
									context.stroke();
								}

								function drawPointLines3() {
									makeCanvasReady();
									var k = 0;
									for (var j = 0; j != 200; j++) {
										var a = matchToPoints[j];

										if (k == 1) {
											var color = "#F02424";
										}
										if (k == 2) {
											var color = "#AF7AC5";
										}
										if (k == 3) {
											var color = "#154360";
										}
										if (k == 4) {
											var color = "#3498DB";
										}
										if (k == 5) {
											var color = "#0E6251";
										}
										if (k == 6) {
											var color = "#1ABC9C";
										}
										if (k == 7) {
											var color = "#7D6608";
										}
										if (k == 8) {
											var color = "#F1C40F";
										}
										if (k == 9) {
											var color = "#F39C12";
										}
										if (k == 10) {
											var color = "#D35400";
										}
										if (k == 11) {
											var color = "#CACFD2";
										}
										if (k == 12) {
											var color = "#99A3A4";
										}
										if (k == 13) {
											var color = "#E74C3C";
										}
										context.beginPath();
										context.strokeStyle = color;
										if (a != null) {
											for (var i = 0; i != a.length; i++) {
												if (i == 0) {
													context.moveTo((a[i][0]), (a[i][1]));
												} else {
													context.lineTo((a[i][0]), (a[i][1]));
												}
											}
											context.stroke();
											k++;
										} else {
											console.log("fail");
										}
									}
								}

								function printAuto() {
									var matchNumber = document.getElementById("matchNum").value;
									var b = matchToPoints4[matchNumber];
									var c = matchToPoints5[matchNumber];
									var d = matchToPoints6[matchNumber];
									if (b != null) {
										console.log("Auto Upper Made: " + b + ", Auto Upper Miss: " + c + ", Auto Lower Goal: " + d);
										document.getElementById('auto').innerHTML = "Auto Upper Made: " + b;
										document.getElementById('auto2').innerHTML = "Auto Upper Miss: " + c;
										document.getElementById('auto3').innerHTML = "Auto Lower Made: " + d;
									}
								}

								function printAuto1() {
									document.getElementById('auto').innerHTML = "";
									document.getElementById('auto2').innerHTML = "";
									document.getElementById('auto3').innerHTML = "";
								}
							</script>
							<h4><b>Match Number </b></h4>
							<div class="col-md-7">
								<select onclick="drawPointLines(); printAuto();" id="matchNum" class="form-control">
									<?php
									for ($i = 0; $i != sizeof($teamData[8]); $i++) {
										echo ("<option value='" . $teamData[8][$i][2] . "'>" . $teamData[8][$i][2] . "</option>");
									}

									?>
								</select>
							</div>
							<div class="col-md-5">
								<div>
									<button type="button" onClick="drawPointLines3(); printAuto1()" class=" btn btn-material-orange" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> Show All </button>
								</div>
								<div>
									<span id='auto'></span>
								</div>
								<div>
									<span id='auto2'></span>
								</div>
								<div>
									<span id='auto3'></span>
								</div>
							</div>
						</div>




						<div class="col-md-7">
							<a>
								<h3><b><u>Teleop Shooting:</u></b></h3>
							</a>
						</div>
						<div>
							<canvas id="myCanvas2" width="600" height="300" style="border:1px solid #d3d3d3;"></canvas>
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

								for ($i = 0; $i != sizeof($teamData[8]); $i++) {
									echo ("matchToPoints2[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][25] . ";");
								}
								for ($i = 0; $i != sizeof($teamData[8]); $i++) {
									echo ("matchToPoints7[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][11] . ";");
								}
								for ($i = 0; $i != sizeof($teamData[8]); $i++) {
									echo ("matchToPoints8[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][12] . ";");
								}
								for ($i = 0; $i != sizeof($teamData[8]); $i++) {
									echo ("matchToPoints9[" . $teamData[8][$i][2] . "] = " . $teamData[8][$i][13] . ";");
								}

								?>
								<?php


								for ($i = 0; $i != sizeof($teamData[8]); $i++) {
									$a += ('' . $teamData[8][$i][2] . ',');
								}
								$a = substr($a, 0, -2);

								?>
								imageObj2.onload = function() {
									makeCanvasReady2();
									var ctx2 = document.getElementById("dataChart").getContext("2d");
									window.myLine = new Chart(ctx2).Line(lineChartData, {
										responsive: true
									});
								};
								imageObj2.src = 'images/field.png';

								function makeCanvasReady2() {
									context2.clearRect(0, 0, 600, 300);
									context2.drawImage(imageObj2, 0, 0, 600, 300);
									console.log("hi");
								}

								function adjustCanvas() {
									$("#canvasHolder").css('height', $(window).height() - 25);
									$("#canvasHolder").css('height', $(window).height() - 25);
									$("#main").attr('width', $("#canvasHolder").width());
									$("#main").attr('height', $("#canvasHolder").height());
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
											context2.fillRect((6 / 7) * (a[i][0]), (6 / 7) * (a[i][1]), 5, 5);
										} else if (((b / (b + c)) >= 0.5)) {
											context2.fillStyle = "#fff200";
											context2.fillRect((6 / 7) * (a[i][0]), (6 / 7) * (a[i][1]), 5, 5);
										} else if (((b / (b + c)) >= 0.3)) {
											context2.fillStyle = "#ff9100";
											context2.fillRect((6 / 7) * (a[i][0]), (6 / 7) * (a[i][1]), 5, 5);
										} else if (((b / (b + c)) >= 0)) {
											context2.fillStyle = "#ff0000";
											context2.fillRect((6 / 7) * (a[i][0]), (6 / 7) * (a[i][1]), 5, 5);
										} else if (b + c == 0) {
											context2.fillStyle = "#000000";
											context2.fillRect((6 / 7) * (a[i][0]), (6 / 7) * (a[i][1]), 5, 5);
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
													context2.fillRect((6 / 7) * (a[i][0]), (6 / 7) * (a[i][1]), 5, 5);
												} else if (((b / (b + c)) >= 0.5)) {
													context2.fillStyle = "#fff200";
													context2.fillRect((6 / 7) * (a[i][0]), (6 / 7) * (a[i][1]), 5, 5);
												} else if (((b / (b + c)) >= 0.3)) {
													context2.fillStyle = "#ff9100";
													context2.fillRect((6 / 7) * (a[i][0]), (6 / 7) * (a[i][1]), 5, 5);
												} else if (((b / (b + c)) >= 0)) {
													context2.fillStyle = "#ff0000";
													context2.fillRect((6 / 7) * (a[i][0]), (6 / 7) * (a[i][1]), 5, 5);
												} else if (b + c == 0) {
													context2.fillStyle = "#000000";
													context2.fillRect((6 / 7) * (a[i][0]), (6 / 7) * (a[i][1]), 5, 5);
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
						</div>
						<div class="col-md-7">
							<select onclick="drawPoint2(); printTeleop();" id="matchNum2" class="form-control">
								<?php

								for ($i = 0; $i != sizeof($teamData[8]); $i++) {
									echo ("<option value='" . $teamData[8][$i][2] . "'>" . $teamData[8][$i][2] . "</option>");
								}

								?>
							</select>
						</div>
						<div class="col-md-5">
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
						</div>
					</div>

					<div>

						<button type="button" onClick="" class="enlargedtext stylishLower1" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 100 Percent </button>
						<button type="button" onClick="" class="enlargedtext stylishLower2" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 50 Percent </button>
						<button type="button" onClick="" class="enlargedtext stylishLower3" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 30 Percent </button>
						<button type="button" onClick="" class="enlargedtext stylishLower4" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 0 Percent </button>
						<button type="button" onClick="" class="enlargedtext stylishLower5" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> Lower Only </button>
					</div>

				</div>



				<a>
					<h3><b><u>Statistics:</u></b></h3>
				</a>
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr class="danger">
								<td>DNP</td>
								<td><?php echo (getTotalDNP($teamNumber)); ?></td>
							</tr>
							<tr class="info">
								<td>Average Auto Upper Goal</td>
								<td><?php echo round(getAvgUpperGoal($teamNumber), 2); ?></td>
							</tr>
							<tr class="success">
								<td>Average Auto Lower Goal</td>
								<td><?php echo round(getAvgLowerGoal($teamNumber), 2); ?></td>
							</tr>
							<tr class="danger">
								<td>Average Teleop Upper Goal</td>
								<td><?php echo round(getAvgUpperGoalT($teamNumber), 2); ?></td>
							</tr>
							<tr class="info">
								<td>Average Teleop Lower Goal</td>
								<td><?php echo round(getAvgLowerGoalT($teamNumber), 2); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="col-md-4">
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
					<div class="col-md-4">
						<a>
							<h3><b><u>Comments:</u></b></h3>
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
										<td>Average Penalties</td>
										<td><?php echo round(getAvgPenalties($teamNumber), 2); ?></td>
									</tr>

									<tr class="success">
										<td>Lead Scout ELO</td>
										<td><?php 
                            echo round(dummy_lookup($leadScoutELO, $teamNumber));
                      ?></td>
									</tr>

									<tr class="info">
										<td>Total Defense</td>
										<td><?php echo round(getTotalDefense($teamNumber), 2); ?></td>
									</tr>

								</tbody>
							</table>

						</div>
					</div>
					<div class="col-md-4">
						<a>
							<h3><b><u>Climb Statistics:</u></b></h3>
						</a>
						<div class="table-responsive">
							<table class="table">
								<tbody>
									<tr class="info">
										<td>Average Climbs</td>
										<td><?php echo round(getAvgClimb($teamNumber), 2); ?></td>
									</tr>
									<tr class="success">
										<td>Total Climbs</td>
										<td><?php echo round(getTotalClimb($teamNumber), 2); ?></td>
									</tr>
									<tr class="danger">
										<td>Total Low Climbs</td>
										<td><?php echo round(getTotalSingleClimb($teamNumber), 2); ?></td>
									</tr>
									<tr class="info">
										<td>Total Med Climbs</td>
										<td><?php echo round(getTotalDoubleClimb($teamNumber), 2); ?></td>
									</tr>
									<tr class="success">
										<td>Total High Climbs</td>
										<td><?php echo round(getTotalTripleClimb($teamNumber), 2); ?></td>
									</tr>
									<tr class="danger">
										<td>Total Traversal Climbs</td>
										<td><?php echo round(getTotalQuadClimb($teamNumber), 2); ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>


				</div>
		</div>
	</div>
	</div>
	</div>

	<style>
		.stylishLower1 {
			background-color: #3cff00;
			border: none;
			color: white;
			padding: 15px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
		}

		.stylishLower2 {
			background-color: #fff200;
			border: none;
			color: white;
			padding: 15px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
		}

		.stylishLower3 {
			background-color: #ff9100;
			border: none;
			color: white;
			padding: 15px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
		}

		.stylishLower4 {
			background-color: #ff0000;
			border: none;
			color: white;
			padding: 15px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
		}

		.stylishLower5 {
			background-color: #000000;
			border: none;
			color: white;
			padding: 15px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
		}
	</style>


</body>

</html>
<?php include("footer.php"); ?>