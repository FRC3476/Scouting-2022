<html>
<?php
include("header.php") ?>

<body>
	<?php include("navBar.php") ?>

	<div class="container row-offcanvas row-offcanvas-left">
		<div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
			<h2>Team Ranking</h2>
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
					<th>TBA CCWM</th>
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
					$CCWM = getCCWM($teamNumber);
					$DPR = getDPR($teamNumber);

					





					echo ("<tr>
					<td><a href='matchStrategy.php?team=" . $teamNumber . "'>" . $teamNumber . "</a></td>
					<th>" . $picklist . "</th>
					<th>" . $UpperShotPercentage . "</th>
					<th>" . round($avgTeleopUpper,3) . "</th>
					<th>" . round($avgTeleopLower,3) . "</th>
					<th>" . round($avgAutoUpper,3) . "</th>
					<th>" . round($avgAutoLower,3) . "</th>
					<th>" . round($avgDriveRank,3) . "</th>
					<th>" . $maxTeleopUpper . "</th>
					<th>" . $maxTeleopLower . "</th>
					<th>" . $maxAutoUpper . "</th>
					<th>" . $maxAutoLower . "</th>
					<th>" . round($avgClimb,3) . "</th>
					<th>" . $totalDefense . "</th>
					<th>" . round($OPR,3) . "</th>
					<th>" . round($CCWM,3) . "</th>
					<th>" . round($DPR,3) . "</th>
					</tr>");
				}

				?>
			</table>
		</div>
	</div>
</body>
<?php include("footer.php") ?>