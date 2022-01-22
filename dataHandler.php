<?php
include("matchInput.php");

function filter($str)
{
	return filter_var($str, FILTER_SANITIZE_STRING);
}
?>

<?php
if (isset($_POST['matchNum'])) {

	include("databaseLibrary.php");
	$user = filter($_POST['userName']);

	$matchNum = filter($_POST['matchNum']);
	$teamNum = filter($_POST['teamNum']);
	$allianceColor = filter($_POST['allianceColor']);
	$autoPath = filter($_POST['autoPath']);
	$crossLineA = filter($_POST['crossLineA']);
	$ID = $matchNum . "-" . $teamNum;

	$upperGoal = filter($_POST['upperGoal']);
	$upperGoalMiss = filter($_POST['upperGoalMiss']);
	$lowerGoal = filter($_POST['lowerGoal']);
	$lowerGoalMiss = filter($_POST['lowerGoalMiss']);

	$upperGoalT = filter($_POST['upperGoalT']);
	$upperGoalMissT = filter($_POST['upperGoalMissT']);
	$lowerGoalT = filter($_POST['lowerGoalT']);
	$lowerGoalMissT = filter($_POST['lowerGoalMissT']);

	$climb = filter($_POST['climb']);
	$climbTwo = filter($_POST['climbTwo']);
	$climbThree = filter($_POST['climbThree']);
	$climbFour = filter($_POST['climbFour']);

	$issues = filter($_POST['issues']);
	$defenseBot = filter($_POST['defenseBot']);
	$defenseComments = filter($_POST['defenseComments']);
	$matchComments = filter($_POST['matchComments']);
	$penalties = filter($_POST['penalties']);
	$cycleCount = filter($_POST['cycleCount']);
	$teleopPath = filter($_POST['teleopPath']);

	matchInput(
		$user,
		$ID,
		$matchNum,
		$teamNum,
		$allianceColor,
		$autoPath,
		$crossLineA,
		$upperGoal,
		$upperGoalMiss,
		$lowerGoal,
		$lowerGoalMiss,
		$upperGoalT,
		$upperGoalMissT,
		$lowerGoalT,
		$lowerGoalMissT,
		$climb,
		$climbTwo,
		$climbThree,
		$climbFour,
		$issues,
		$defenseBot,
		$defenseComments,
		$matchComments,
		$penalties,
		$cycleCount,
		$teleopPath
	);
}


?>
<script>
	function getMatchData() {
		$.ajax({
			type: "POST",
			url: "dugthescout/dataHandler.php?matchData:",
			data: JSON.stringify(nums),
			success: success,
		});
	}
</script>