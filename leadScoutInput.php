<!DOCTYPE html>

<html>
<?php include("navBar.php");

function filter($str)
{
	return filter_var($str, FILTER_SANITIZE_STRING);
}
if (isset($_POST['matchNum'])) {
	include("databaseLibrary.php");
	$userName = filter($_POST['userName']);
	$matchNum = filter($_POST['matchNum']);
	$team1Dri = filter($_POST['team1Dri']);
	$team2Dri = filter($_POST['team2Dri']);
	$team3Dri = filter($_POST['team3Dri']);
	$team4Dri = filter($_POST['team4Dri']);
	$team5Dri = filter($_POST['team5Dri']);
	$team6Dri = filter($_POST['team6Dri']);

	$id = $userName . $matchNum;

	leadScoutInput(
		$userName,
		$matchNum,
		$id,
		$team1Dri,
		$team2Dri,
		$team3Dri,
		$team4Dri,
		$team5Dri,
		$team6Dri
	);
}
?>

<head></head>

<body>
	<!--Rest of the code for the inputs-->
	<div id="input">
		<h1 style="text-decoration: underline; color: rgb(15,129,120); padding-left: 30px; font-size: 30px">Lead Scout Input:</h1>



		<h4 style=" color: rgb(120,120,120); font-family: sans-serif; display: inline-block; padding-left: 30px">Match Number:</h4>
		<input style="display: inline-block; border:none; border-bottom: solid; border-color: rgba(120,120,120,50); border-width: 2px;width: 30%; margin-left: 30px; font-size: 16px; outline: none;" type="text" placeholder="Match Number" id="matchNum">

		<h4 style=" color: rgb(120,120,120); font-family: sans-serif; display: inline-block; padding-left: 30px">Username:</h4>
		<input style="display: inline-block; border:none; border-bottom: solid; border-color: rgba(120,120,120,50); border-width: 2px;width: 30%; margin-left: 30px; font-size: 16px; outline: none;" type="text" placeholder="User Name" id="userName">


		<h3 style="font-size: 19px; font-family: sans-serif;font-weight: lighter;  padding-left: 30px; padding-bottom: 7px">Team Rank:</h3>

		<!--Team 1-->



		<input id="team1Dri" type="text" placeholder="Team 1">


		<br />
		<br />
		<br />

		<!--Team 2-->

		<input id="team2Dri" type="text" placeholder="Team 2">


		<br />
		<br />
		<br />

		<!--Team 3-->

		<input id="team3Dri" type="text" placeholder="Team 3">

		<br>

		<input id="team4Dri" type="text" placeholder="Team 4">


		<br />
		<br />
		<br />

		<!--Team 2-->

		<input id="team5Dri" type="text" placeholder="Team 5">


		<br />
		<br />
		<br />

		<!--Team 3-->

		<input id="team6Dri" type="text" placeholder="Team 6">

		<br>
		</br>
		</br>

		<input style="background-color: rgb(15,129,120); padding-left: 25px; padding-right: 25px; padding-top: 8px; padding-bottom: 8px; font-size: 15px; font-weight: medium; color: white; margin-left: 30px; border-radius: 5px; margin-top: 5px;" type="submit" name="submit" value="Submit data" onclick="postwith('');">

	</div>
	<br />
	<br />




	</div>


	<style type="text/css">
		#input {
			margin-left: 10%;
			padding-left: 10px;
			/*border-style: inset;  */
			margin-right: 10%;
			padding-bottom: 5px;
			padding-top: 5px;
			box-shadow: 0px 0px 12px #000000;
			/*  0 0 0 10px hsl(0, 0%, 70%),
    0 0 0 15px hsl(0, 0%, 100%);*/

		}

		/*style for the textboxes*/


		#team1 {
			display: inline-block;
			border: none;
			border-bottom: solid;
			border-color: rgba(120, 120, 120, 50);
			border-width: 2px;
			width: 30%;
			margin-left: 30px;
			font-size: 15px;
			outline: none;
			padding-bottom: 10px;
		}


		#team2 {
			display: inline-block;
			border: none;
			border-bottom: solid;
			border-color: rgba(120, 120, 120, 50);
			border-width: 2px;
			width: 30%;
			margin-left: 30px;
			font-size: 15px;
			outline: none;
			padding-bottom: 10px;
		}

		#team3 {
			display: inline-block;
			border: none;
			border-bottom: solid;
			border-color: rgba(120, 120, 120, 50);
			border-width: 2px;
			width: 30%;
			margin-left: 30px;
			font-size: 15px;
			outline: none;
			padding-bottom: 10px;
		}

		#team4 {
			display: inline-block;
			border: none;
			border-bottom: solid;
			border-color: rgba(120, 120, 120, 50);
			border-width: 2px;
			width: 30%;
			margin-left: 30px;
			font-size: 15px;
			outline: none;
			padding-bottom: 10px;
		}

		#team5 {
			display: inline-block;
			border: none;
			border-bottom: solid;
			border-color: rgba(120, 120, 120, 50);
			border-width: 2px;
			width: 30%;
			margin-left: 30px;
			font-size: 15px;
			outline: none;
			padding-bottom: 10px;
		}

		#team6 {
			display: inline-block;
			border: none;
			border-bottom: solid;
			border-color: rgba(120, 120, 120, 50);
			border-width: 2px;
			width: 30%;
			margin-left: 30px;
			font-size: 15px;
			outline: none;
			padding-bottom: 10px;
		}



		#team1:hover {
			border-color: orange;
		}

		#team2:hover {
			border-color: orange;
		}

		#team3:hover {
			border-color: orange;
		}

		#team4:hover {
			border-color: orange;
		}

		#team5:hover {
			border-color: orange;
		}

		#team6:hover {
			border-color: orange;
		}
	</style>
	<script>
		function postwith(to) {

			var myForm = document.createElement("form");
			myForm.method = "post";
			myForm.action = to;

			if (document.getElementById('team1Dri').value == "") {
				document.getElementById('team1Dri').value = 0;
			}
			if (document.getElementById('team2Dri').value == "") {
				document.getElementById('team2Dri').value = 0;
			}
			if (document.getElementById('team3Dri').value == "") {
				document.getElementById('team3Dri').value = 0;
			}
			if (document.getElementById('team4Dri').value == "") {
				document.getElementById('team4Dri').value = 0;
			}
			if (document.getElementById('team5Dri').value == "") {
				document.getElementById('team5Dri').value = 0;
			}
			if (document.getElementById('team6Dri').value == "") {
				document.getElementById('team6Dri').value = 0;
			}



			var names = [
				'userName',
				'matchNum',
				'team1Dri',
				'team2Dri',
				'team3Dri',
				'team4Dri',
				'team5Dri',
				'team6Dri'
			];

			var nums = [
				document.getElementById('userName').value,
				document.getElementById('matchNum').value,
				document.getElementById('team1Dri').value,
				document.getElementById('team2Dri').value,
				document.getElementById('team3Dri').value,
				document.getElementById('team4Dri').value,
				document.getElementById('team5Dri').value,
				document.getElementById('team6Dri').value
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



</body>

</html>
<?php include("footer.php"); ?>