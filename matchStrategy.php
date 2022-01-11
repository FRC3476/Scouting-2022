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
				$teamData = getTeamData($teamNumber);
			}
			/*
			if ($_GET["team2"]) {
				$teamNumber2 = $_GET["team2"];
				include("databaseName.php");
				include("databaseLibrary.php");
				//getTeamData($_GET["team"]);
				$teamData2 = getTeamData($teamNumber2);
			}
			
			if ($_GET["team3"]) {
				$teamNumber3 = $_GET["team3"];
				include("databaseName.php");
				include("databaseLibrary.php");
				//getTeamData($_GET["team"]);
				$teamData3 = getTeamData($teamNumber3);
			}
			*/
			?>
			<form action="" method="get">
				Enter Team Number: <input class="control-label" type="number" name="team" id="team" size="10" height="10" width="40">
				<!--Enter Team 2 Number: <input class="control-label" type="number" name="team2" id="team2" size="10" height="10" width="40">
				Enter Team 3 Number: <input class="control-label" type="number" name="team3" id="team3" size="10" height="10" width="40"> -->

				<button id="submit" class="btn btn-primary" onclick="">Display</button>
				<div class="row">
                <div class="col-md-5">
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
						<button class=" btn btn-material-brown"> Auto Upper Attempted</button>
						<button class=" btn btn-material-green">Teleop Upper Made</button>
						<button class=" btn btn-material-yellow">Teleop Upper Attempted</button>
						<button class=" btn btn-material-blue">Cycle Count</button>
						<button class=" btn btn-material-red">Total Lower Made</button>
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
										label: "Auto Upper Attempted",
										fillColor: "rgba(220,220,220,0.1)",
										strokeColor: "brown",
										pointColor: "rgba(107, 75, 26,1)",
										pointStrokeColor: "#ffff00",
										pointHighlightFill: "#fff",
										pointHighlightStroke: "rgba(220,220,220,1)",
										data: <?php echo (json_encode(getAutoUpperGoalMiss($teamNumber)) + (getAutoUpperGoal($teamNumber))); ?>
									},

									{
										label: "Teleop Upper Goal",
										fillColor: "rgba(220,220,220,0.1)",
										strokeColor: "green",
										pointColor: "rgba(16, 224, 19,1)",
										pointStrokeColor: "#ffff00",
										pointHighlightFill: "#fff",
										pointHighlightStroke: "rgba(220,220,220,1)",
										data: <?php echo (json_encode(getTeleopUpperGoal($teamNumber))); ?>
									},

									{
										label: "Teleop Total Upper Attempted",
										fillColor: "rgba(220,220,220,0.1)",
										strokeColor: "yellow",
										pointColor: "rgba(215,222,16,1)",
										pointStrokeColor: "#ffff00",
										pointHighlightFill: "#fff",
										pointHighlightStroke: "rgba(220,220,220,1)",
										data: <?php echo (json_encode((getTeleopUpperGoalMiss($teamNumber)) + (getTeleopUpperGoal($teamNumber)))); ?>
									},

									{
										label: "Cycle Count",
										fillColor: "rgba(220,220,220,0.1)",
										strokeColor: "blue",
										pointColor: "rgba(44, 130, 201, 1)",
										pointStrokeColor: "#ffff00",
										pointHighlightFill: "#fff",
										pointHighlightStroke: "rgba(220,220,220,1)",
										data: <?php echo (json_encode(getCycle($teamNumber))); ?>
									},

									{
										label: "Total Lower Goal",
										fillColor: "rgba(220,220,220,0.1)",
										strokeColor: "red",
										pointColor: "rgba(219, 20, 20,1)",
										pointStrokeColor: "#ffff00",
										pointHighlightFill: "#fff",
										pointHighlightStroke: "rgba(220,220,220,1)",
										data: <?php echo (json_encode(getLowerGoal($teamNumber))); ?>
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
								if ($teamData[8] != null){
									
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
									for (var j = 0; j != 200; j++){
										var a = matchToPoints[j];
										
										if (k==1){
											var color = "#512E5F";
										}
										if (k==2){
											var color = "#AF7AC5";
										}
										if (k==3){
											var color = "#154360";
										}
										if (k==4){
											var color = "#3498DB";
										}
										if (k==5){
											var color = "#0E6251";
										}
										if (k==6){
											var color = "#1ABC9C";
										}
										if (k==7){
											var color = "#7D6608";
										}
										if (k==8){
											var color = "#F1C40F";
										}
										if (k==9){
											var color = "#F39C12";
										}
										if (k==10){
											var color = "#D35400";
										}
										if (k==11){
											var color = "#CACFD2";
										}
										if (k==12){
											var color = "#99A3A4";
										}
										if (k == 13){
											var color = "#E74C3C";
										}
										context.beginPath();
										context.strokeStyle = color;
										if (a != null){
											for (var i = 0; i != a.length; i++) {
												if (i == 0) {
													context.moveTo((a[i][0]), (a[i][1]));
												} else {
													context.lineTo((a[i][0]), (a[i][1]));
												}
											}
											context.stroke();
											k++;
										}else{
											console.log("fail");
										}
									}
								}

                                function printAuto() {
                                    var matchNumber = document.getElementById("matchNum").value;
                                    var b = matchToPoints4[matchNumber];
                                    var c = matchToPoints5[matchNumber];
									var d = matchToPoints6[matchNumber];
									if (b != null){
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





						<!--

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
                                var dataList = [];
								<?php

								/*
								if ($teamData[10] != null){

									for ($i = 0; $i != sizeof($teamData[10]); $i++) {
										echo ("matchToPoints2[" . $teamData[10][$i][2] . "] = " . $teamData[10][$i][7] . ";");
									}
									for ($i = 0; $i != sizeof($teamData[9]); $i++) {
										echo ("matchToPoints3[" . $teamData[9][$i][2] . "] = " . $teamData[9][$i][14] . ";");
									}
								}
								*/
								?>
								<?php
								/*
									for ($i = 0; $i != sizeof($teamData[10]); $i++) {
										$a += ('' . $teamData[10][$i][2] . ',');
									}
									$a = substr($a, 0, -2);
									*/
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
									var b = matchToPoints3[matchNumber2];
									for (var i = 0; i != a.length; i++) {
										if (((b[i][1]/(b[i][2]+b[i][1])) == 1)){
											context2.fillStyle = "#059400";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
											console.log(b[i][1]);
										}else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.7)){
											context2.fillStyle = "#d0ff00";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
										} else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.5)){
											context2.fillStyle = "#ffd900";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
										} else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.3)){
											context2.fillStyle = "#ff8c00";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
										} else if ((b[i][2]) == 0){
											context2.fillStyle = "#000000";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
										}else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.1)){
											context2.fillStyle = "#ff0088";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
                                        }else{
											context2.fillStyle = "#940000";
											context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
										}
									}
								}

								function drawPoint3() {
                                    makeCanvasReady2();
									for (var j = 0; j != 200; j++){
										var a = matchToPoints2[j];
										var b = matchToPoints3[j];
										if (a != null){
											for (var i = 0; i != a.length; i++) {
												if (((b[i][1]/(b[i][2]+b[i][1])) == 1)){
													context2.fillStyle = "#059400";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												} else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.7)){
													context2.fillStyle = "#d0ff00";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												} else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.5)){
													context2.fillStyle = "#ffd900";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												} else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.3)){
													context2.fillStyle = "#ff8c00";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												} else if ((b[i][2]) == 0){
													context2.fillStyle = "#000000";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												}else if (((b[i][1]/(b[i][2]+b[i][1])) >= 0.1)){
													context2.fillStyle = "#ff0088";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												}else{
													context2.fillStyle = "#940000";
													context2.fillRect((a[i][0]), (a[i][1]), 5, 5);
												}
											}
										} else {
											continue;
											console.log("fail");
										}
									}
								}

								function printTeleop() {
                                    var matchNumber = document.getElementById("matchNum").value;
                                    var b = matchToPoints7[matchNumber];
                                    var c = matchToPoints8[matchNumber];
									var d = matchToPoints9[matchNumber];
									if (b != null){
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
										<?php /*
										for ($i = 0; $i != sizeof($teamData[10]); $i++) {
											echo ("<option value='" . $teamData[10][$i][2] . "'>" . $teamData[10][$i][2] . "</option>");

										} */?>
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

								<button type="button" onClick="" class="enlargedtext stylishLower8" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 100 Percent </button>
								<button type="button" onClick="" class="enlargedtext stylishLower2" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 70 Percent </button>
								<button type="button" onClick="" class="enlargedtext stylishLower3" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 50 Percent </button>
								<button type="button" onClick="" class="enlargedtext stylishLower4" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 30 Percent </button>
								<button type="button" onClick="" class="enlargedtext stylishLower5" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 10 Percent </button>
								<button type="button" onClick="" class="enlargedtext stylishLower6" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> 0 Percent </button>
								<button type="button" onClick="" class="enlargedtext stylishLower7" id="bigFont"><a id="lowerGoalTemp" class="enlargedtext"></a> Lower Only </button>
							</div>
						</div>
-->

						<h4><b>Team Info</b></h4>

						<div class="table-responsive" style="height:800px; margin:20 auto;">
							<table class="table">
								<tbody>
									<tr class="info">
										<td>Avg Predicted Score</td>
										<td><?php echo (round(getAvgScore($teamNumber),4)); ?></td>
									</tr>
									<tr class="info">
										<td>Avg Teleop Upper</td>
										<td><?php echo (round(getAvgUpperGoalT($teamNumber),3)); ?></td>
									</tr>
									<tr class="info">
										<td>Max Teleop Upper</td>
										<td><?php echo (round(getMaxUpperGoalT($teamNumber),3)); ?></td>
									</tr>
									<tr class="info">
										<td>Avg Cycle Count</td>
										<td><?php echo (round(getAvgCycleCount($teamNumber),3)); ?></td>
									</tr>
									<tr class="info">
										<td>Avg Offense Rank</td>
										<td><?php echo (round(getAvgOffenseRank($teamNumber),3)); ?></td>
									</tr>

									
									<tr class="success">
										<td>Avg Auto Upper</td>
										<td><?php echo (getAvgUpperGoal($teamNumber)); ?></td>
									</tr>
									<tr class="success">
										<td>Max Auto Upper</td>
										<td><?php echo (getMaxUpperGoal($teamNumber)); ?></td>
									</tr>
									<tr class="success">
										<td>Avg Climb</td>
										<td><?php echo (getAvgClimb($teamNumber)); ?></td>
									</tr>
									

									<tr class="danger">
										<td>Total Defense</td>
										<td><?php echo (getTotalDefense($teamNumber)); ?></td>
									</tr>
									<tr class="danger">
										<td>Avg Defense Rank</td>
										<td><?php echo (getAvgDefenseRank($teamNumber)); ?></td>
									</tr>
									<tr class="danger">
										<td>Avg Drive Rank</td>
										<td><?php echo (round(getAvgDriveRank($teamNumber),3)); ?></td>
									</tr>
									<tr class="danger">
										<td>Avg Penalties</td>
										<td><?php echo (getAvgPenalties($teamNumber)); ?></td>
									</tr>
									
								</tbody>
							</table>

						</div>
                    </div>
                 </div>
            </form>
		</div>
	</div>
    <style>
    .stylishLower1 {
        background-color: #00ff0d;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
		}
    .stylishLower2 {
        background-color: #d0ff00;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
		}
    .stylishLower3 {
        background-color: #ffd900;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
		}
    .stylishLower4 {
        background-color: #ff8c00;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
		}
    .stylishLower5 {
        background-color: #ff0088;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
		}
    .stylishLower6 {
        background-color: #940000;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
		}
    .stylishLower7 {
        background-color: #0f0f0f;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
		}
	.stylishLower8 {
        background-color: #059400;
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