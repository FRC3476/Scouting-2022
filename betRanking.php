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
					<th>User</th>
					<th>Score</th>
					
				</tr>
				<?php
				include("databaseLibrary.php");
				$userList = getUserList();
				foreach ($userList as $userName) {

					$i = 0;
					$score = getBetScore($userName);

					echo ("<tr>
					<th>" . $userName . "</th>
					<th>" . $score . "</th>
					</tr>");
				}

				?>
			</table>
		</div>
	</div>
</body>
<?php include("footer.php") ?>