<!DOCTYPE html>

<html>
<?php include("navBar.php");

	function filter($str){
		return filter_var($str, FILTER_SANITIZE_STRING);
	}
	if(isset($_POST['matchNum'])){
		include("databaseLibrary.php");
		$matchNum = filter($_POST['matchNum']);
		$team1Off = filter($_POST['team1Off']);
		$team2Off = filter($_POST['team2Off']);
		$team3Off = filter($_POST['team3Off']);
		$team1Def = filter($_POST['team1Def']);
		$team2Def = filter($_POST['team2Def']);
		$team3Def = filter($_POST['team3Def']);
		$team1Dri = filter($_POST['team1Dri']);
		$team2Dri = filter($_POST['team2Dri']);
		$team3Dri = filter($_POST['team3Dri']);

		leadScoutInput($matchNum,
						$team1Off,
						$team2Off,
						$team3Off,
						$team1Def,
						$team2Def,
						$team3Def,
						$team1Dri,
						$team2Dri,
						$team3Dri);
	}
?>
<head></head>
<body>
<!--Rest of the code for the inputs-->
	<div id="input">
	<h1 style="text-decoration: underline; color: rgb(15,129,120); padding-left: 30px; font-size: 30px">Head Scout Input:</h1>



	<h4 style=" color: rgb(120,120,120); font-family: sans-serif; display: inline-block; padding-left: 30px">Match Number:</h4>

	<input style="display: inline-block; border:none; border-bottom: solid; border-color: rgba(120,120,120,50); border-width: 2px;width: 30%; margin-left: 30px; font-size: 16px; outline: none;" type="text" placeholder="Match Number" id="matchNum">


	<h3 style="font-size: 19px; font-family: sans-serif;font-weight: lighter;  padding-left: 30px; padding-bottom: 7px">Offense Rank:</h3>


<div id="inBox">
<!--Team 1-->
	<input id="team1Off" id="team1"  type="text" placeholder="Team 1 Offense Rank">


<br/>
<br>
<br/>

<!--Team 2-->

<input id="team2Off"  type="text" placeholder="Team 2 Offense Rank">


<br/>
<br/>
<br/>

<!--Team 3-->

<input id="team3Off"  type="text" placeholder="Team 3 Offense Rank">


<br/>
<br/>
<br/>

<h3 style="font-size: 19px; font-family: sans-serif;font-weight: lighter;  padding-left: 30px; padding-bottom: 7px">Defense Rank:</h3>

<!--Team 1-->



<input id="team1Def"  type="text" placeholder="Team 1 Defense Rank">


<br/>
<br/>
<br/>

<!--Team 2-->

<input id="team2Def"  type="text" placeholder="Team 2 Defense Rank">


<br/>
<br/>
<br/>

<!--Team 3-->

<input id="team3Def" type="text" placeholder="Team 3 Defense Rank">


</div>
<br/>
<br/>

<h3 style="font-size: 19px; font-family: sans-serif;font-weight: lighter;  padding-left: 30px; padding-bottom: 7px">Drive Rank:</h3>

<!--Team 1-->



<input id="team1Dri"  type="text" placeholder="Team 1 Drive Rank">


<br/>
<br/>
<br/>

<!--Team 2-->

<input id="team2Dri"  type="text" placeholder="Team 2 Drive Rank">


<br/>
<br/>
<br/>

<!--Team 3-->

<input id="team3Dri" type="text" placeholder="Team 3 Drive Rank">


</div>
<br/>
<br/>


<input style="background-color: rgb(15,129,120); padding-left: 25px; padding-right: 25px; padding-top: 8px; padding-bottom: 8px; font-size: 15px; font-weight: medium; color: white; margin-left: 30px; border-radius: 5px; margin-top: 5px;" type="submit" name="submit" value="Submit data" onclick="postwith('');">


</div>


<style type="text/css">
	#input{
		margin-left: 10%;
		padding-left: 10px;
		/*border-style: inset;  */
		margin-right: 10%;
		padding-bottom: 5px;
		padding-top: 5px;
		box-shadow:0px 0px 12px #000000;
  /*  0 0 0 10px hsl(0, 0%, 70%),
    0 0 0 15px hsl(0, 0%, 100%);*/

	}

/*style for the textboxes*/


  	#team1{
  		display: inline-block; border:none; border-bottom: solid; border-color: rgba(120,120,120,50); border-width: 2px; width: 30%; margin-left: 30px; font-size: 15px; outline: none; padding-bottom: 10px;
  	}


  	#team2{
  		display: inline-block; border:none; border-bottom: solid; border-color: rgba(120,120,120,50); border-width: 2px; width: 30%; margin-left: 30px; font-size: 15px; outline: none; padding-bottom: 10px;
  	}

  	#team3{
  		display: inline-block; border:none; border-bottom: solid; border-color: rgba(120,120,120,50); border-width: 2px; width: 30%; margin-left: 30px; font-size: 15px; outline: none; padding-bottom: 10px;
  	}

  	#team4{
  		display: inline-block; border:none; border-bottom: solid; border-color: rgba(120,120,120,50); border-width: 2px; width: 30%; margin-left: 30px; font-size: 15px; outline: none; padding-bottom: 10px;
  	}

  	#team5{
  		display: inline-block; border:none; border-bottom: solid; border-color: rgba(120,120,120,50); border-width: 2px; width: 30%; margin-left: 30px; font-size: 15px; outline: none; padding-bottom: 10px;
  	}

  	#team6{
  		display: inline-block; border:none; border-bottom: solid; border-color: rgba(120,120,120,50); border-width: 2px; width: 30%; margin-left: 30px; font-size: 15px; outline: none; padding-bottom: 10px;
  	}



  	#team1:hover{
  		border-color: orange;
  	}

  	#team2:hover{
  		border-color: orange;
  	}

  	#team3:hover{
  		border-color: orange;
  	}

  	#team4:hover{
  		border-color: orange;
  	}

  	#team5:hover{
  		border-color: orange;
  	}

  	#team6:hover{
  		border-color: orange;
  	}




</style>
<script>
function postwith(to){

		var myForm = document.createElement("form");
		myForm.method="post";
		myForm.action = to;

		var names = [
		'matchNum',
		'team1Off',
		'team2Off',
		'team3Off',
		'team1Def',
		'team2Def',
		'team3Def',
		'team1Dri',
		'team2Dri',
		'team3Dri'
		];

		var nums = [
		document.getElementById('matchNum').value,
		document.getElementById('team1Off').value,
		document.getElementById('team2Off').value,
		document.getElementById('team3Off').value,
		document.getElementById('team1Def').value,
		document.getElementById('team2Def').value,
		document.getElementById('team3Def').value,
		document.getElementById('team1Dri').value,
		document.getElementById('team2Dri').value,
		document.getElementById('team3Dri').value,
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
