<html>
<?php
include("navBar.php");
include("databaseLibrary.php");
$event = getEvent();
//echo (json_encode($event)); 
?>
<script src="Orange-Rind/js/orangePersist.js"></script>
<script src="matchInputDynamic.js"></script>
<script>
	function postwith(to) {
		if (document.getElementById('penalties').value == "") {
			document.getElementById('penalties').value = 0;
		}

		if (document.getElementById('matchNum').value == "" || document.getElementById('teamNum').value == "" || document.getElementById('allianceColor').value == "") {
			alert("Please enter a Team, Alliance Color, and Match Number");
			return;
		}

		var nums = {
			'userName': document.getElementById('userName').value,
			'matchNum': document.getElementById('matchNum').value,
			'teamNum': document.getElementById('teamNum').value,
			'allianceColor': document.getElementById('allianceColor').value,
			'autoPath': JSON.stringify(coordinateList),
			'crossLineA': document.getElementById('crossLineA').checked ? 1 : 0,

			'upperGoal': upperGoal,
			'upperGoalMiss': upperGoalMiss,
			'lowerGoal': lowerGoal,
			'lowerGoalMiss': lowerGoalMiss,

			'upperGoalT': upperGoalT,
			'upperGoalMissT': upperGoalMissT,
			'lowerGoalT': lowerGoalT,
			'lowerGoalMissT': lowerGoalMissT,

			'climb': climb,
			'climbTwo': climbTwo,
			'climbThree': climbThree,
			'climbFour': climbFour,

			'issues': document.getElementById('issues').value,
			'defenseBot': document.getElementById('defenseBot').checked ? 1 : 0,
			'defenseComments': document.getElementById('defenseComments').value,
			'matchComments': document.getElementById('matchComments').value,
			'penalties': document.getElementById('penalties').value,
			'cycleCount': cycleCount,
			'teleopPath': JSON.stringify(coordinateList2),
			'doNotPick': document.getElementById('doNotPick').checked ? 1 : 0
		};

		var id = document.getElementById('matchNum').value + "-" + document.getElementById('teamNum').value;

		console.log(JSON.stringify(nums));
		$.post("dataHandler.php", nums).done(function(data) {}).done(function() {
			alert("Submission Succeeded! Form Reloading.");
			location.reload(true);
		}).fail(function() {
			alert("Submission Failed! Please alert your head or lead scout!");
		});
	}
</script>

<body>

	<div class="container row-offcanvas row-offcanvas-left">
		<div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
			<div class="row" style="text-align: center;">
				<div class="col-md-2">
					User:
					<input type="text" name="userName" onKeyUp="saveUserName()" id="userName" size="8" class="form-control">
				</div>
				<div class="col-md-2">
					Match Number:
					<input type="text" name="matchNum" id="matchNum" size="8" class="form-control">
				</div>
				<div class="col-md-2">
					Team Number:
					<input type="text" name="teamNum" id="teamNum" size="8" class="form-control">
				</div>
				<div class="col-md-3">
					Alliance Color:
					<select id="allianceColor" class="form-control">
						<option value="" disabled selected>Choose Alliance</option>
						<option value='blue'>Blue</option>
						<option value='red'>Red</option>
					</select>
				</div>
				<div class="col-md-3">
					<button id="Switch" onclick="autotele();" class="btn btn-primary">Teleop</button>
				</div>
			</div>

			<!--Auto Scouting-->
			<div id="autoscouting">
				<a>
					<h2><b><u>Auto Scouting:</u></b></h2>
				</a>
				<div class="row">
					<div class="col-md-4">
						<div class="togglebutton" id="reach">
							<h4><b>Left Tarmac:</b></h4>
							<label>
								<input id="crossLineA" type="checkbox">
							</label>
						</div>
						<a href="javascript:void(0)" class="btn btn-raised btn-boulder btn-material-teal-600" onclick="clearPath()"><b>CLEAR PATH</b></a>
						<div class="row">
							<canvas id="myCanvas" width=600px height=460px style="border:0px solid #d3d3d3;">
								<script src="Drawing.js"></script>
							</canvas>
						</div>
					</div>
				</div>
				<div>
					<div class="row">
						<a>
							<h3><b><u> Upper Goal:</u></b></h3>
						</a>
						<button class="disable-dbl-tap-zoom-uppera" type="button" onClick="updateupperGoal()" id="bigFont"><a id="upperGoal" class="enlargedtext">0</a> Upper Goal </button>
						<button class="disable-dbl-tap-zoom-uppera" type="button" onClick="updateupperGoalMiss()" id="bigFont"> Upper Goal Miss <a id="upperGoalMiss" class="enlargedtext">0</a></button>
						<button class="disable-dbl-tap-zoom" type="button" onClick="upperGoalClear()" class="enlargedtext stylishUpperMiss" id="bigFont"> Clear <a class="enlargedtext"></a></button>
						<br>
						<br>
						<br>

						<a>
							<h3><b><u>Lower Goal:</u></b></h3>
						</a>
						<button class="disable-dbl-tap-zoom-lowera" type="button" onClick="updatelowerGoal()" class="enlargedtext stylishLower" id="bigFont"><a id="lowerGoal" class="enlargedtext">0</a> Lower Goal </button>
						<button class="disable-dbl-tap-zoom-lowera" type="button" onClick="updatelowerGoalMiss()" class="enlargedtext stylishLower" id="bigFont"> Lower Goal Miss <a id="lowerGoalMiss" class="enlargedtext">0</a></button>
						<button class="disable-dbl-tap-zoom" type="button" onClick="lowerGoalClear()" class="enlargedtext stylishUpperMiss" id="bigFont"> Clear <a class="enlargedtext"></a></button>
						<br>
						<br>
					</div>
				</div>
			</div>

			<!--Tepeop scouting section-->
			<div id="teleopscouting">
				<a>
					<h2><b><u>Teleop Scouting:</u></b></h2>
				</a>

				<script>
					function updatelowerGoalMiss() {
						lowerGoalMiss += increment;
						document.getElementById("lowerGoalMiss").innerHTML = lowerGoalMiss;

					}

					function updatelowerGoal() {
						lowerGoal += increment;

						document.getElementById("lowerGoal").innerHTML = lowerGoal;

					}

					function updateupperGoalMiss() {

						upperGoalMiss += increment;

						document.getElementById("upperGoalMiss").innerHTML = upperGoalMiss;

					}

					function updateupperGoal() {
						upperGoal += increment;

						document.getElementById("upperGoal").innerHTML = upperGoal;

					}

					function upperGoalClear() {
						upperGoal = 0;
						upperGoalMiss = 0;

						document.getElementById("upperGoal").innerHTML = upperGoalT;
						document.getElementById("upperGoalMiss").innerHTML = upperGoalT;

					}

					function lowerGoalClear() {
						lowerGoal = 0;
						lowerGoalMiss = 0;

						document.getElementById("lowerGoal").innerHTML = upperGoalT;
						document.getElementById("lowerGoalMiss").innerHTML = upperGoalT;

					}

					function check() {

						eventCode = '<?=$event?>';;
						matchNumberCode = eventCode + document.getElementById('matchNum').value;
						match = document.getElementById('matchNum').value;

						if (match > 500) {
							postwith();
						} else {
							fetch('https://www.thebluealliance.com/api/v3/match/' + matchNumberCode + '/simple?X-TBA-Auth-Key=VPexr6soymZP0UMtFw2qZ11pLWcaDSxCMUYOfMuRj5CQT3bzoExsUGHuO1JvyCyU')
								.then(response => {
									return response.json();
								})
								.then(data => {
									team1 = (data["alliances"]["blue"]["team_keys"][0]).substring(3);
									team2 = (data["alliances"]["blue"]["team_keys"][1]).substring(3);
									team3 = (data["alliances"]["blue"]["team_keys"][2]).substring(3);
									team4 = (data["alliances"]["red"]["team_keys"][0]).substring(3);
									team5 = (data["alliances"]["red"]["team_keys"][1]).substring(3);
									team6 = (data["alliances"]["red"]["team_keys"][2]).substring(3);

									let teamNumberInt = document.getElementById('teamNum').value;
									let teamNumberString = teamNumberInt.toString();

									if ((teamNumberString != team1) && (teamNumberString != team2) && (teamNumberString != team3) && (teamNumberString != team4) && (teamNumberString != team5) && (teamNumberString != team6)) {
										alert("This team is not playing in this match");
										return;
									} else {
										postwith();
									}
								});
						}
					}









					upperGoalT = 0;
					upperGoalMissT = 0;
					lowerGoalT = 0;
					lowerGoalMissT = 0;
					climb = 0;
					climbTwo = 0;
					climbThree = 0;
					climbFour = 0;
					increment = 1;
					cycleCount = "[]";


					function updateupperGoalT() {
						upperGoalT += increment;

						document.getElementById("upperGoalT").innerHTML = upperGoalT;

					}

					function minusupperGoalT() {
						upperGoalT -= increment;

						document.getElementById("upperGoalT").innerHTML = upperGoalT;

					}

					function updateupperGoalMissT() {
						upperGoalMissT += increment;
						document.getElementById("upperGoalMissT").innerHTML = upperGoalMissT;

					}

					function minusupperGoalMissT() {
						upperGoalMissT -= increment;
						document.getElementById("upperGoalMissT").innerHTML = upperGoalMissT;

					}

					function updatelowerGoalT() {
						lowerGoalT += increment;
						document.getElementById("lowerGoalT").innerHTML = lowerGoalT;

					}

					function minuslowerGoalT() {
						lowerGoalT -= increment;
						document.getElementById("lowerGoalT").innerHTML = lowerGoalT;

					}

					function updatelowerGoalMissT() {
						lowerGoalMissT += increment;
						document.getElementById("lowerGoalMissT").innerHTML = lowerGoalMissT;

					}

					function minuslowerGoalMissT() {
						lowerGoalMissT -= increment;
						document.getElementById("lowerGoalMissT").innerHTML = lowerGoalMissT;

					}

					function upperGoalClearT() {
						upperGoalT = 0;
						upperGoalMissT = 0;

						document.getElementById("upperGoalT").innerHTML = upperGoalT;
						document.getElementById("upperGoalMissT").innerHTML = upperGoalMissT;

					}

					function lowerGoalClearT() {
						lowerGoalT = 0;
						lowerGoalMissT = 0;

						document.getElementById("lowerGoalT").innerHTML = lowerGoalT;
						document.getElementById("lowerGoalMissT").innerHTML = lowerGoalMissT;

					}

					function addCoordinate2() {
						coordinateList2.push(tempCoordinateList2[tempCoordinateList2.length - 1]);
						tempCoordinateList2 = [];
					}

					function climbTyp(climbType) {
						if (climbType == 1) {
							climb = 1;
							climbTwo = 0;
							climbThree = 0;
							climbFour = 0;
						} else {
							if (climbType == 2) {
								climbTwo = 1;
								climbThree = 0;
								climb = 0;
								climbFour = 0;
							} else {
								if (climbType == 3) {
									climbThree = 1;
									climb = 0;
									climbTwo = 0;
									climbFour = 0;
								} else {
									if (climbType == 4) {
										climbThree = 0;
										climb = 0;
										climbTwo = 0;
										climbFour = 1;
									}
								}
							}
						}
					}
				</script>

				<script>
					var increment = 1;
					var upperGoal = 0;
					var upperGoalMiss = 0;
					var lowerGoal = 0;
					var lowerGoalMiss = 0;

					var upperGoalT = 0;
					var upperGoalMissT = 0;
					var lowerGoalT = 0;
					var lowerGoalMissT = 0;
				</script>

				<a>
					<h3><b><u>Upper Goal:</u></b></h3>
				</a>
				<div class="row">
					<button class="disable-dbl-tap-zoom-upper" type="button" onClick="updateupperGoalT()" id="bigFont"><a id="upperGoalT" class="enlargedtext">0</a> Upper Goal</button>
					<button class="disable-dbl-tap-zoom-upper" type="button" onClick="updateupperGoalMissT()" id="bigFont"> Upper Goal Miss <a id="upperGoalMissT" class="enlargedtext">0</a></button>
					<br>
					<br>
					<button class="disable-dbl-tap-zoom-unsave" type="button" onClick="minusupperGoalT()" id="bigFont"><a id="upperGoalT" class="enlargedtext"></a> ---- </button>
					<button class="disable-dbl-tap-zoom-unsave" type="button" onClick="minusupperGoalMissT()" id="bigFont"> ---- <a id="upperGoalMissT" class="enlargedtext"></a></button>


					<a>
						<h3><b><u>Lower Goal:</u></b></h3>
					</a>
					<button class="disable-dbl-tap-zoom-lower" type="button" onClick="updatelowerGoalT()" class="enlargedtext stylishLower" id="bigFont"><a id="lowerGoalT" class="enlargedtext">0</a> Lower Goal </button>
					<button class="disable-dbl-tap-zoom-lower" type="button" onClick="updatelowerGoalMissT()" class="enlargedtext stylishLower" id="bigFont"> Lower Goal Miss <a id="lowerGoalMissT" class="enlargedtext">0</a></button>
					<br>
					<br>
					<button class="disable-dbl-tap-zoom-unsave1" type="button" onClick="minuslowerGoalT()" id="bigFont"><a id="upperGoalT" class="enlargedtext"></a> ---- </button>
					<button class="disable-dbl-tap-zoom-unsave1" type="button" onClick="minuslowerGoalMissT()" id="bigFont"> ---- <a id="upperGoalMissT" class="enlargedtext"></a></button>
					<br>
					<br>
				</div>

				<div>
					<div class="row">
						<canvas id="myCanvas2" width=700px height=350px style="border:0px solid #d3d3d3;">
							<script src="Drawing2.js"></script>
						</canvas>
					</div>

					<button class="disable-dbl-tap-zoom" type="button" onClick="undoDraw()" class="enlargedtext stylishUpperMiss" id="bigFont"> Undo <a class="enlargedtext"></a></button>

				</div>

				<!--Defense-->
				<a>
					<h3><b><u>Defense:</u></b></h3>
				</a>
				<div class="togglebutton" id="reach">
					<h4><b>Defense?</b></h4>
					<label>
						<input id="defenseBot" type="checkbox">
					</label>
				</div>

				<h4><b><u>Defense Comments: </u></b></h4>
				<textarea placeholder="Please write strategy of the robot or interesting observations of the robot" type="text" id="defenseComments" class="form-control md-textarea" rows="6"></textarea>
				<br>

				<!--Climb-->
				<a>
					<h3><b><u>Climb:</u></b></h3>
				</a>
				<input type="radio" onClick="climbTyp(0)" name="ClimbTyp" value="None"> None&nbsp&nbsp</button>
				<input type="radio" onClick="climbTyp(1)" name="ClimbTyp" value="Single"> Low&nbsp&nbsp</button>
				<input type="radio" onClick="climbTyp(2)" name="ClimbTyp" value="Double"> Med&nbsp&nbsp</button>
				<input type="radio" onClick="climbTyp(3)" name="ClimbTyp" value="Triple"> High&nbsp&nbsp</button>
				<input type="radio" onClick="climbTyp(4)" name="ClimbTyp" value="Quad"> Traversal&nbsp&nbsp</button>

				<h4><b><u>Penalties: </u></b></h4>
				<textarea placeholder="Number of Penalties" type="text" id="penalties" class="form-control md-textarea" rows="6">0</textarea>

				<a>
					<h3><b><u>Robot Issues:</u></b></h3>
				</a>
				<select id="issues" multiple="" class="form-control">
					<option value="N/A">None</option>
					<option value="dead">Dead</option>
					<option value="stopped working">Stopped Working</option>
					<option value="fell over">Fell Over</option>
				</select>

				<div class="togglebutton" id="reach">
					<h4><b>DNP?</b></h4>
					<label>
						<input id="doNotPick" type="checkbox">
					</label>
				</div>

				<h4><b><u>Comments / Strategy: </u></b></h4>
				<textarea placeholder="Please write strategy of the robot or interesting observations of the robot" type="text" id="matchComments" class="form-control md-textarea" rows="6"></textarea>
				<br>

				<br> <br>
				<div style="padding: 5px; padding-bottom: 10;">
					<input type="button" value="Submit Data" id="submitButton" class="btn btn-primary" onclick="check('')" />


				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	</div>

	<style>
		.stylishLower {
			background-color: rgb(58, 133, 129);
			color: white;
			border-radius: 2px;
			font-family: Helvetica;
			font-weight: bold;
			/*To get rid of weird 3D affect in some browsers*/
			border: solid rgb(58, 133, 129);
		}

		.stylishLower:hover {
			background-color: Orange;
			border-color: Orange;
		}

		.stylishUpperMiss {
			background-color: rgb(255, 0, 0);
			color: white;
			border-radius: 2px;
			font-family: Helvetica;
			font-weight: bold;
			/*To get rid of weird 3D affect in some browsers*/
			border: solid rgb(255, 0, 0);
		}

		.stylishLowerMiss:hover {
			background-color: Orange;
			border-color: Orange;
		}


		.stylishUpper {
			background-color: rgb(255, 120, 50);
			color: white;
			border-radius: 2px;
			font-family: Helvetica;
			font-weight: bold;
			/*To get rid of weird 3D affect in some browsers*/
			border: solid rgb(255, 120, 50);
		}

		.stylishUpper:hover {
			background-color: Orange;
			border-color: Orange;
		}

		#bigFont {
			font-size: 20px
		}

		#mediumFont {
			font-size: 15px
		}

		#smallFont {
			font-size: 10px
		}

		.feedback:hover {
			background-color: Orange;
		}

		.disable-dbl-tap-zoom {
			touch-action: manipulation;
		}

		.disable-dbl-tap-zoom-upper {
			touch-action: manipulation;
			background-color: rgb(255, 120, 50);
			color: white;
			border-radius: 2px;
			font-family: Helvetica;
			font-weight: bold;
			/*To get rid of weird 3D affect in some browsers*/
			border: solid rgb(255, 120, 50);
			height: 240px;
			width: 564px;
		}

		.disable-dbl-tap-zoom-uppera {
			touch-action: manipulation;
			background-color: rgb(255, 120, 50);
			color: white;
			border-radius: 2px;
			font-family: Helvetica;
			font-weight: bold;
			/*To get rid of weird 3D affect in some browsers*/
			border: solid rgb(255, 120, 50);
			height: 100px;
			width: 564px;
		}

		.disable-dbl-tap-zoom-save {
			touch-action: manipulation;
			background-color: rgb(58, 156, 129);
			color: white;
			border-radius: 2px;
			font-family: Helvetica;
			font-weight: bold;
			/*To get rid of weird 3D affect in some browsers*/
			border: solid rgb(58, 156, 129);
			height: 240px;
			width: 275px;
		}

		.disable-dbl-tap-zoom-unsave {
			touch-action: manipulation;
			background-color: rgb(171, 95, 82);
			color: white;
			border-radius: 2px;
			font-family: Helvetica;
			font-weight: bold;
			/*To get rid of weird 3D affect in some browsers*/
			border: solid rgb(171, 95, 82);
			height: 40px;
			width: 564px;
		}

		.disable-dbl-tap-zoom-unsave1 {
			touch-action: manipulation;
			background-color: rgb(45, 105, 101);
			color: white;
			border-radius: 2px;
			font-family: Helvetica;
			font-weight: bold;
			/*To get rid of weird 3D affect in some browsers*/
			border: solid rgb(45, 105, 101);
			height: 40px;
			width: 564px;
		}

		.disable-dbl-tap-zoom-lower {
			touch-action: manipulation;
			background-color: rgb(53, 176, 169);
			color: white;
			border-radius: 2px;
			font-family: Helvetica;
			font-weight: bold;
			/*To get rid of weird 3D affect in some browsers*/
			border: solid rgb(53, 176, 169);
			height: 240px;
			width: 564px;
		}

		.disable-dbl-tap-zoom-lowera {
			touch-action: manipulation;
			background-color: rgb(53, 176, 169);
			color: white;
			border-radius: 2px;
			font-family: Helvetica;
			font-weight: bold;
			/*To get rid of weird 3D affect in some browsers*/
			border: solid rgb(53, 176, 169);
			height: 100px;
			width: 564px;
		}
	</style>
</body>

</html>
<?php include("footer.php"); ?>