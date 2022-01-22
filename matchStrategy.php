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
			?>
			<form action="" method="get">
				Enter Team Number: <input class="control-label" type="number" name="team" id="team" size="10" height="10" width="40">

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
								labels: <?php  echo (json_encode(matchNum($teamNumber)));  ?>,
								datasets: [

									{
										label: "Auto Upper Goal",
										fillColor: "rgba(220,220,220,0.1)",
										strokeColor: "purple",
										pointColor: "rgba(146, 16, 222,1)",
										pointStrokeColor: "#ffff00",
										pointHighlightFill: "#fff",
										pointHighlightStroke: "rgba(220,220,220,1)",
										data: <?php  echo (json_encode(getAutoUpperGoal($teamNumber))); ?>
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