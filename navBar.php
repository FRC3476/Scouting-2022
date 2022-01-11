<?php include("header.php"); ?>
<!-- Image and text -->
<nav class="navbar navbar-expand-lg navbar-dark orange" role="navigation">
	<a class="navbar-brand" href="#">
		<img src="images/Logo.png" height="40" class="d-inline-block align-top" alt="">

	</a>
	<div class="container">
		<!-- Drop down button for small screens -->
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<!-- Left justified logo/text -->
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php" style="color:Black;">
				Scouting 2020
			</a>
		</div>
		<!-- What goes under the drop down button/rest of navbar -->
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-left">
				<!--<li class = "dropdown">
					<a  class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="color:Black;" >Forms<b class="caret"></b></a>
	                    <ul class="dropdown-menu">-->
				<li><a href="matchInput.php" style="color:Black;">Match Form</a></li>
				<li><a href="leadScoutInput.php" style="color:Black;">LS Input</a></li>
				<li><a href="pitInput.php" style="color:Black;">PS Form</a></li>
				<li><a href="pictureUpload.php" style="color:Black;">Picture Upload</a></li>
				<li><a href="matchData.php" style="color:Black;">Match Data</a></li>
				<!--<li><a href="databaseOperations.php" style="color:Black;">Database Op</a></li>-->
				<!--        </ul>
				</li>-->
				<!--<li><a href="userRegistration.php" style="color:Black;">User Registration</a></li>-->
				<li><a href="teamData.php" style="color:Black;">Team Data</a></li>
				<li><a href="teamRanking.php" style="color:Black;">Ranking</a></li>
				<li><a href="matchStrategy.php" style="color:Black;">Strategy</a></li>
				<li><a href="dataValidation.php" style="color:Black;">Validate</a></li>
				<!--<li><a href="teamFilter.php" style="color:Black;">Team Filter</a></li>-->

			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php
				if (isset($_SESSION["userIDCookie"])) {
					echo ('<li class="dropdown">
                                <a data-target="#" class="dropdown-toggle" data-toggle="dropdown">' . $_SESSION["userIDCookie"] . '<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                <li><a href="javascript:void(0)">Action</a></li>
                                <li class="divider"></li>
                                <li><a href="logout.php">Logout</a></li>
                                </ul>
                                </ul>
                                </li>');
					echo (" <script>
										 $(document).ready(function(){
											$('.dropdown-toggle').dropdown();
										});
									</script>'");
				}
				?>
		</div>
	</div>
</nav>

<script>
	$(document).ready(function() {
		$.material.init();
	});
</script>