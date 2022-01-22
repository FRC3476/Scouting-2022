function postwith(to){

		var nums = {
		'userName' : document.getElementById('userName').value,
		'matchNum' : document.getElementById('matchNum').value,
		'teamNum' : document.getElementById('teamNum').value,
		'allianceColor' : document.getElementById('allianceColor').value,
		'autoPath' : JSON.stringify(coordinateList),
		'crossLineA' : document.getElementById('crossLineA').checked?1:0,

		'upperGoal' : upperGoal,
		'upperGoalMiss' : upperGoalMiss,
		'lowerGoal' : lowerGoal,
		'lowerGoalMiss' : lowerGoalMiss,

		'upperGoalT' : upperGoalT,
		'upperGoalMissT' : upperGoalT,
		'lowerGoalT' : lowerGoalT,
		'lowerGoalMissT' : lowerGoalMissT,

		'climb' : climb,
		'climbTwo' : climbTwo,
		'climbThree' : climbThree,
		'climbFour' : climbFour,

		'issues' : document.getElementById('issues').value,
		'defenseBot' : document.getElementById('defenseBot').checked?1:0,
		'defenseComments' : document.getElementById('defenseComments').value,
		'matchComments' : document.getElementById('matchComments').value,
		'penalties': document.getElementById('penalties').value,
		'cycleCount': cycleCount,
		'teleopPath' : JSON.stringify(coordinateList2)
		};

		var id = document.getElementById('matchNum').value + "-" + document.getElementById('teamNum').value;
		console.log(JSON.stringify(nums));
		orangePersist.collection("avr").doc(id).set(nums);
		$.post( "dataHandler.php", nums).done(function( data ) {
		});
	}
