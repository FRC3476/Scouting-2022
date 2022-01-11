<html>
<?php include("navBar.php");

function filter($str){
	return filter_var($str, FILTER_SANITIZE_STRING);
}
 if( isset( $_POST['teamNumber']) ) {
		if($_POST['teamNumber']!=""){


			 include("databaseLibrary.php");
			 $teamNumber = filter($_POST['teamNumber']);
			 $teamName = filter($_POST['teamName']);
			 $numBatteries = filter($_POST['numBatteries']);
			 $chargedBatteries = filter($_POST['chargedBatteries']);	
			 $codeLanguage = filter($_POST['codeLanguage']);
			 $pitComments = filter($_POST['pitComments']);
			 $climbHelp = filter($_POST['climbHelp']);




			pitScoutInput( $teamNumber,
						$teamName,
						$numBatteries,
						$chargedBatteries,
						$codeLanguage,
						$pitComments,
						$climbHelp);
			}
 }
 ?>
<head>

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-material-design-master/dist/css/ripples.min.css" rel="stylesheet">
    <link href="bootstrap-material-design-master/dist/css/material-wfont.min.css" rel="stylesheet">
	<script src="jquery-1.11.2.min.js"></script>
	<script src="sorttable.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1">


</head>
<body>
<style>
#overallForm {
		font-size: 15px;
		display: inline-block;
}
</style>
<div class="container row-offcanvas row-offcanvas-left">
	<div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
	<a><h2><b><u>Pit Scout Form:</u></b></h2></a>
            <form action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<b><text class="col-lg-2 control-label" >Team Number: </text></b>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="teamNumber" name="teamNumber" placeholder=" ">
				</div>
			</div>

			<div class="col-lg-2">
			<b><br>Team Name: </b>
			</div>
				<div class="col-lg-10">
				<input type="text" class="form-control" id="teamName" name="teamName" placeholder=" ">
			</div>

			<div class="col-lg-2">
			<b><br>How Many Batteries in the Pit: </b>
			</div>
				<div class="col-lg-10">
				<input type="text" class="form-control" id="numBatteries" name="numBatteries" placeholder=" ">
				</div>

			<div class="col-lg-2">
			<b><br>How Many Batteries Can Be Charged Simultaneously: </b>
			</div>
				<div class="col-lg-10">
				<input type="text" class="form-control" id="chargedBatteries" name="chargedBatteries" placeholder=" ">
				<br>
				</div>

				<div class="col-lg-2">
				<b><br>Code Language: </b>
				</div>
				<div class="col-lg-10">
				<input type="text" class="form-control" id="codeLanguage" name="codeLanguage" placeholder=" ">
				<br>
				</div>

				<div class="col-lg-2">
				<b><br>Have a Climber? </b>
				</div>
				<div class="col-lg-10">
				<input type="text" class="form-control" id="climbHelp" name="climbHelp" placeholder=" ">
				<br>
				</div>

			<div class="col-lg-2">
			<b><br>Comments: </b>
			</div>
				<div class="col-lg-10">
				<input type="text" class="form-control" id="pitComments" name="pitComments" placeholder=" ">
				<br>
				</div>

			<div class="col-lg-12 col-sm-12 col-xs-12">
				<input id="PitScouting" type="submit" class="btn btn-primary" value="Submit Data" onclick="" >
			</form>
			</div>
			<br>


	</div>
</div>



<style>
/* The container */
.container2 {
	display: inline-block;
	position: relative;
	cursor: pointer;
	font-size: 22px;
	bottom:10px;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

/* Hide the browser's default checkbox */
.container2 input {
	position: absolute;
	opacity: 0;
	cursor: pointer;
	height: 0;
	width: 0;
	margin-left:100%;

}

/* Create a custom checkbox */
.checkmark {
	position: absolute;
	top: 0;
	left:0;
	height: 25px;
	width: 25px;
	background-color: #eee;
	border-radius: 5px;
}

.container:hover input ~ .checkmark {
	background-color: orange;
}

.container2 input:checked ~ .checkmark {
	background-color: rgb(15,129,120);
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
	content: "";
	position: absolute;
	display: none;
}

/* Show the checkmark when checked */
.container2 input:checked ~ .checkmark:after {
	display: block;
}

/* Style the checkmark/indicator */
.container2 .checkmark:after {
	left: 9px;
	top: 5px;
	width: 5px;
	height: 10px;
	border: solid white;
	border-width: 0 3px 3px 0;
	-webkit-transform: rotate(45deg);
	-ms-transform: rotate(45deg);
	transform: rotate(45deg);
}
</style>



<?php include("footer.php"); ?>
