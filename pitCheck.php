<html>
<?php
include("header.php") ?>

<body>
	<?php include("navBar.php") ?>

	<div class="container row-offcanvas row-offcanvas-left">
		<div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
			<h2>Pit Scout Check</h2>
			<table class="sortable table table-hover" id="RawData" border="1">
				<tr>
					<th>Team Number</th>
					<th>Pit Scouted?</th>
					<th>Picture Taken?</th>		
				</tr>
				<?php
				include("databaseLibrary.php");
				$teamList = getEventTeams();
				foreach ($teamList as $teamNumber) {

					$i = 0;
					$pitScouted = (getPit($teamNumber));
					$pictureTaken = getPicture($teamNumber);
					
					echo ("<tr>
					<td><a href='matchStrategy.php?team=" . $teamNumber . "'>" . $teamNumber . "</a></td>
					<th>" . $pitScouted . "</th>
					<th>" . $pictureTaken . "</th>
					</tr>");
				}

				?>
			</table>
		</div>
	</div>
</body>
<?php include("footer.php") ?>