<html>
<?php
include("header.php") ?>
<script src="js/bootstrap.min.js"></script>

<body>
	<?php include("navBar.php") ?>

	<div class="container row-offcanvas row-offcanvas-left">
		<div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
			<h2>Pit Scout Check</h2>

			<a href='pitInput.php'>
        		<button class="btn btn-primary">
            		PS Form
        		</button>
    		</a>
			<a href='pictureUpload.php'>
        		<button class="btn btn-primary">
            		Picture Upload
        		</button>
    		</a>

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
					
					if($pitScouted == "Yes"){
						$Pitcolor = "lightgreen";
					}else{
						$Pitcolor = "White";
					}

					if($pictureTaken == "Yes"){
						$Piccolor = "lightgreen";
					}else{
						$Piccolor = "White";
					}

					if(($pictureTaken == "Yes")&&($pitScouted == "Yes")){
						$color = "lightgreen";
					}else{
						$color = "White";
					}

					echo ("<tr>
					<td bgcolor=".$color."><a href='matchStrategy.php?team=" . $teamNumber . "'>" . $teamNumber . "</a></td>
					<td bgcolor=".$Pitcolor."><a href='pitInput.php?teamNumber=" . $teamNumber . "'>" . $pitScouted . "</a></td>
					<td bgcolor=".$Piccolor."><a href='pictureUpload.php?teamNumber=" . $teamNumber . "'>" . $pictureTaken . "</a></td>
					</tr>");
				}

				?>
			</table>
		</div>
	</div>
</body>
<?php include("footer.php") ?>