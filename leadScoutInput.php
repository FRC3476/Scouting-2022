<!DOCTYPE html>

<html>
<?php include("navBar.php");
?>

<head>


</head>

<body>
	<div class="container row-offcanvas row-offcanvas-left">
		<div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
			<h3><b><u>Match Number:</u></b></h3>
			</a>
			<select id="match_type" value="<?php $types = ((isset($_GET["match_type"])) ? htmlspecialchars($_GET["match_type"]) : ""); ?>">
				<option <?php if ($types == "q") : ?>selected="selected" <?php endif; ?> value="q">Qual</option>
				<option <?php if ($types == "qf1") : ?>selected="selected" <?php endif; ?> value="qf1">QF 1</option>
				<option <?php if ($types == "qf2") : ?>selected="selected" <?php endif; ?> value="qf2">QF 2</option>
				<option <?php if ($types == "qf3") : ?>selected="selected" <?php endif; ?> value="qf3">QF 3</option>
				<option <?php if ($types == "qf4") : ?>selected="selected" <?php endif; ?> value="qf4">QF 4</option>
				<option <?php if ($types == "sf1") : ?>selected="selected" <?php endif; ?> value="sf1">SF 1</option>
				<option <?php if ($types == "sf2") : ?>selected="selected" <?php endif; ?> value="sf2">SF 2</option>
				<option <?php if ($types == "f1") : ?>selected="selected" <?php endif; ?> value="f1">Final</option>
			</select>
			<input type="text" name="match" id="match" value="<?php echo ((isset($_GET["match"])) ? htmlspecialchars($_GET["match"]) : ""); ?>" size="8" class="form-control">
			<br />
			<h4 style=" color: rgb(120,120,120); font-family: sans-serif; display: inline-block; padding-left: 30px">Username:</h4>
			<input style="display: inline-block; border:none; border-bottom: solid; border-color: rgba(120,120,120,50); border-width: 2px;width: 30%; margin-left: 30px; font-size: 16px; outline: none;" type="text" placeholder="User Name" id="userName">
			<br />

			<button id="get" class="btn btn-primary" onclick="getTeams('');">Get Teams</button>
			<br />
		</div>
	</div>
	<!--Rest of the code for the inputs-->

	<?php
	include('databaseLibrary.php');
	function filter($str)
	{
		return filter_var($str, FILTER_UNSAFE_RAW);
	}
	if (
		isset($_POST['match']) && isset($_POST['match_type'])
	) {
		$matchNum = filter($_POST['match']);
		$matchNum = "m" . $matchNum;
		$matchType = filter($_POST['match_type']);
		if ($matchNum != null) {
			$event = getEventRaw();
			$match = $event . "_" . $matchType . $matchNum;
			$team1Blue = getMatchAlliance($match, "blue", 0);
			$team2Blue = getMatchAlliance($match, "blue", 1);
			$team3Blue = getMatchAlliance($match, "blue", 2);
			$team1Red = getMatchAlliance($match, "red", 0);
			$team2Red = getMatchAlliance($match, "red", 1);
			$team3Red = getMatchAlliance($match, "red", 2);
			echo ("
			<div class='container' id='teams' style='display: grid;align-items: center;justify-items: center;align-content: center;'>
                        <div class='card mb-3 box' id='' style='max-width: 750px; margin-top: 25px' draggable='true'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <img src='images/Logo.png' class='img-fluid rounded-start'
                                        style='max-height: 100px; max-width: 100px; padding: 15px;' alt='...'>
                                </div>
                                <div class='col-md-6'>
                                    <div class='card-body'>
                                        <h3 class='card-title'>" . $team1Blue . "</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class='card mb-3 box' id='' style='max-width: 750px; margin-top: 25px' draggable='true'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <img src='images/Logo.png' class='img-fluid rounded-start'
                                        style='max-height: 100px; max-width: 100px; padding: 15px;' alt='...'>
                                </div>
                                <div class='col-md-6'>
                                    <div class='card-body'>
                                        <h3 class='card-title'>" . $team2Blue . "</h3>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class='card mb-3 box' id='' style='max-width: 750px; margin-top: 25px' draggable='true'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <img src='images/Logo.png' class='img-fluid rounded-start'
                                        style='max-height: 100px; max-width: 100px; padding: 15px;' alt='...'>
                                </div>
                                <div class='col-md-6'>
                                    <div class='card-body'>
                                        <h3 class='card-title'>" . $team3Blue . "</h3>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class='card mb-3 box' id='' style='max-width: 750px; margin-top: 25px' draggable='true'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <img src='images/Logo.png' class='img-fluid rounded-start'
                                        style='max-height: 100px; max-width: 100px; padding: 15px;' alt='...'>
                                </div>
                                <div class='col-md-6'>
                                    <div class='card-body'>
                                        <h3 class='card-title'>" . $team1Red . "</h3>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class='card mb-3 box' id='' style='max-width: 750px; margin-top: 25px' draggable='true'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <img src='images/Logo.png' class='img-fluid rounded-start'
                                        style='max-height: 100px; max-width: 100px; padding: 15px;' alt='...'>
                                </div>
                                <div class='col-md-6'>
                                    <div class='card-body'>
                                        <h3 class='card-title'>" . $team2Red . "</h3>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class='card mb-3 box' id='' style='max-width: 750px; margin-top: 25px' draggable='true'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <img src='images/Logo.png' class='img-fluid rounded-start'
                                        style='max-height: 100px; max-width: 100px; padding: 15px;' alt='...'>
                                </div>
                                <div class='col-md-6'>
                                    <div class='card-body'>
                                        <h3 class='card-title'>" . $team3Red . "</h3>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
						</div>
                    ");
		}
	}
	?>

	<br />
	<br />
	<div style="display:flex; justify-content:center;">
		<button id="submit" class="btn btn-primary" onclick="postwith('');">Submit</button>
	</div>
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

		.container {
			display: grid;

			gap: 10px;
		}

		.box {
			border: 3px solid #666;
			background-color: #ddd;
			border-radius: .5em;
			padding: 10px;
			cursor: move;
		}

		[draggable] {
			user-select: none;
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
			const unorderedTeams = document.getElementById('teams').getElementsByClassName('card-title');
			let orderedTeams = [];
			for (let i = 0; i < unorderedTeams.length; i++) {
				orderedTeams.push(unorderedTeams[i].outerText);
			}

			console.log(orderedTeams);
			// var myForm = document.createElement("form");
			// myForm.method = "post";
			// myForm.action = to;

			// if (document.getElementById('team1Dri').value == "") {
			// 	document.getElementById('team1Dri').value = 0;
			// }
			// if (document.getElementById('team2Dri').value == "") {
			// 	document.getElementById('team2Dri').value = 0;
			// }
			// if (document.getElementById('team3Dri').value == "") {
			// 	document.getElementById('team3Dri').value = 0;
			// }

			// var names = [
			// 	'matchNum',
			// 	'team1Dri',
			// 	'team2Dri',
			// 	'team3Dri'
			// ];

			// var nums = [
			// 	document.getElementById('matchNum').value,
			// 	document.getElementById('team1Dri').value,
			// 	document.getElementById('team2Dri').value,
			// 	document.getElementById('team3Dri').value,
			// ];


			// for (var i = 0; i != names.length; i++) {
			// 	var myInput = document.createElement("input");
			// 	myInput.setAttribute("name", names[i]);
			// 	myInput.setAttribute("value", nums[i]);
			// 	myForm.appendChild(myInput);
			// }

			// document.body.appendChild(myForm);
			// myForm.submit();
			// document.body.removeChild(myForm);
		}

		function getTeams(to) {

			var myForm = document.createElement("form");
			myForm.method = "post";
			myForm.action = to;

			var names = [
				'match_type',
				'match'
			];

			var nums = [
				document.getElementById('match_type').value,
				document.getElementById('match').value
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


	<!-- <script src="./js/leadscout.js" type="module"></script> -->
	<script>
		var dragSrcEl = null;

		function handleDragStart(e) {
			this.style.opacity = '0.4';

			dragSrcEl = this;

			e.dataTransfer.effectAllowed = 'move';
			e.dataTransfer.setData('text/html', this.innerHTML);
		}

		function handleDragOver(e) {
			if (e.preventDefault) {
				e.preventDefault();
			}

			e.dataTransfer.dropEffect = 'move';

			return false;
		}

		function handleDragEnter(e) {
			this.classList.add('over');
		}

		function handleDragLeave(e) {
			this.classList.remove('over');
		}

		function handleDrop(e) {
			if (e.stopPropagation) {
				e.stopPropagation(); // stops the browser from redirecting.
			}

			if (dragSrcEl != this) {
				dragSrcEl.innerHTML = this.innerHTML;
				this.innerHTML = e.dataTransfer.getData('text/html');
			}

			return false;
		}

		function handleDragEnd(e) {
			this.style.opacity = '1';

			items.forEach(function(item) {
				item.classList.remove('over');
			});
		}


		let items = document.querySelectorAll('.container .box');
		items.forEach(function(item) {
			item.addEventListener('dragstart', handleDragStart, false);
			item.addEventListener('dragenter', handleDragEnter, false);
			item.addEventListener('dragover', handleDragOver, false);
			item.addEventListener('dragleave', handleDragLeave, false);
			item.addEventListener('drop', handleDrop, false);
			item.addEventListener('dragend', handleDragEnd, false);
		});
	</script>
</body>

</html>
<?php include("footer.php"); ?>