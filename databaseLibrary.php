<?php
include("databaseName.php");
//Input- runQuery, establishes connection with server, runs query, closes connection.
//Output- queryOutput, data to/from the tables in phpMyAdmin databases.


function runQuery($queryString)
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $pitScoutTable;
	global $matchScoutTable;
	global $leadScoutTable;
	//Establish Connection
	try {
		$conn = connectToDB();
	} catch (Exception $e) {
		error_log("CREATING DB");
		createDB();
		$conn = connectToDB();
	}
	//new mysqli($servername, $username, $password, $dbname);
	//error_log($queryString);
	try {
		$statement = $conn->prepare($queryString);
	} catch (PDOException $e) {
		error_log($e->getMessage());
		error_log($e->getCode());
		if ($e->getCode() == "42S02") {
			error_log("CREATING TABLES");
			createTables();
		}
		$statement = $conn->prepare($queryString);
	}
	if (!$statement->execute()) {
		die("Failed!");
	}
	try {
		//error_log("".$statement->fetchAll());
		return $statement->fetchAll();
	} catch (Exception $e) {
		return;
	}
}
function createDB()
{
	global $dbname;
	$connection = connectToServer();
	$statement = $connection->prepare('CREATE DATABASE IF NOT EXISTS ' . $dbname);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE DATABASE query failed.");
	}
}
function connectToServer()
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $charset;
	$dsn = "mysql:host=" . $servername . ";charset=" . $charset;
	$opt = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false
	];
	return (new PDO($dsn, $username, $password, $opt));
}
function connectToDB()
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $charset;
	$dsn = "mysql:host=" . $servername . ";dbname=" . $dbname . ";charset=" . $charset;
	$opt = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false
	];
	return (new PDO($dsn, $username, $password, $opt));
}
function createTables()
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $pitScoutTable;
	global $matchScoutTable;
	global $leadScoutTable;
	$conn = connectToDB();
	$query = "CREATE TABLE " . $dbname . "." . $pitScoutTable . " (
			teamNumber VARCHAR(50) NOT NULL PRIMARY KEY,
			teamName VARCHAR(60) NOT NULL,
			numBatteries VARCHAR(20) NOT NULL,
			chargedBatteries VARCHAR(20) NOT NULL,
			codeLanguage VARCHAR(10) NOT NULL,
			pitComments LONGTEXT NOT NULL,
			climbHelp LONGTEXT NOT NULL
		)";
	$statemennt = $conn->prepare($query);
	if (!$statemennt->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE pitScoutTable query failed.");
	}
	$query = "CREATE TABLE " . $dbname . "." . $matchScoutTable . " (
			user VARCHAR(20) NOT NULL,
			ID VARCHAR(8) NOT NULL PRIMARY KEY,
			matchNum INT(11) NOT NULL,
			teamNum INT(11) NOT NULL,
			allianceColor TEXT NOT NULL,
			autoPath LONGTEXT NOT NULL,
			crossLineA INT(11) NOT NULL,
			upperGoal INT(11) NOT NULL,
			upperGoalMiss INT(11) NOT NULL,
			lowerGoal INT(11) NOT NULL,
			lowerGoalMiss INT(11) NOT NULL,
			upperGoalT INT(11) NOT NULL,
			upperGoalMissT INT(11) NOT NULL,
			lowerGoalT INT(11) NOT NULL,
			lowerGoalMissT INT(11) NOT NULL,
			climb TINYINT(4) NOT NULL,
			climbTwo TINYINT(4) NOT NULL,
			climbThree TINYINT(4) NOT NULL,
			climbFour TINYINT(4) NOT NULL,
			issues LONGTEXT NOT NULL,
			defenseBot INT(11) NOT NULL,
			defenseComments LONGTEXT NOT NULL,
			matchComments LONGTEXT NOT NULL,
			penalties INT(11) NOT NULL,
			cycleCount LONGTEXT NOT NULL,
			teleopPath LONGTEXT NOT NULL
		)";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE matchScoutTable query failed.");
	}

	$query = "CREATE TABLE " . $dbname . "." . $leadScoutTable . " (
			matchNum INT(11) NOT NULL PRIMARY KEY,
			team1Off INT(11) NOT NULL,
			team2Off INT(11) NOT NULL,
			team3Off INT(11) NOT NULL,
			team1Def INT(11) NOT NULL,
			team2Def INT(11) NOT NULL,
			team3Def INT(11) NOT NULL,
			team1Dri INT(11) NOT NULL,
			team2Dri INT(11) NOT NULL,
			team3Dri INT(11) NOT NULL
		)";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE leadScoutTable query failed.");
	}

}

//Input- pitScoutInput, Data from pit scout form is assigned to columns in 17template_pitscout.
//Output- queryString and "Success" statement, data put in columns.

function pitScoutInput($teamNumber, $teamName, $numBatteries, $chargedBatteries, $codeLanguage, $pitComments, $climbHelp)
{
	global $pitScoutTable;
	$queryString = "REPLACE INTO `" . $pitScoutTable . "` (`teamNumber`, `teamName`, `numBatteries`,`chargedBatteries`, `codeLanguage`, `pitComments`, `climbHelp`)";
	$queryString = $queryString . ' VALUES ("' . $teamNumber . '", "' . $teamName . '", "' . $numBatteries . '", "' . $chargedBatteries . '", "' . $codeLanguage . '", "' . $pitComments . '", "' . $climbHelp . '")';
	$queryOutput = runQuery($queryString);
}


//Input- getTeamList, accesses match scout table and gets team numbers from it.
//Output- array, list of teams in teamNumber column of pitscout table.
function getTeamList()
{
	global $matchScoutTable;
	$queryStringTwo = "SELECT `teamNum` FROM `" . $matchScoutTable . "`";
	$resultTwo = runQuery($queryStringTwo);
	$teams = array();

	foreach ($resultTwo as $row_key => $row) {
		if (!in_array($row["teamNum"], $teams)) {
			array_push($teams, $row["teamNum"]);
		}
	}
	return ($teams);
}



function matchInput(
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
) {

	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $matchScoutTable;
	$queryString = "REPLACE INTO `" . $matchScoutTable . '`(  `user`,
															 `ID`,
															 `matchNum`,
															 `teamNum`,
															 `allianceColor`,
															 `autoPath`,
															 `crossLineA`,
															 `upperGoal`,
															 `upperGoalMiss`,
															 `lowerGoal`,
															 `lowerGoalMiss`,
															 `upperGoalT`,
															 `upperGoalMissT`,
															 `lowerGoalT`,
															 `lowerGoalMissT`,
															 `climb`,
															 `climbTwo`,
															 `climbThree`,
															 `climbFour`,
															 `issues`,
															 `defenseBot`,
															 `defenseComments`,
															 `matchComments`,
															 `penalties`,
															 `cycleCount`,
															 `teleopPath`)
													VALUES ( "' . $user . '",
															 "' . $ID . '",
															 "' . $matchNum . '",
															 "' . $teamNum . '",
															 "' . $allianceColor . '",
															 "' . $autoPath . '",
															 "' . $crossLineA . '",
															 "' . $upperGoal . '",
															 "' . $upperGoalMiss . '",
															 "' . $lowerGoal . '",
															 "' . $lowerGoalMiss . '",
															 "' . $upperGoalT . '",
															 "' . $upperGoalMissT . '",
															 "' . $lowerGoalT . '",
															 "' . $lowerGoalMissT . '",
															 "' . $climb . '",
															 "' . $climbTwo . '",
															 "' . $climbThree . '",
															 "' . $climbFour . '",
															 "' . $issues . '",
															 "' . $defenseBot . '",
															 "' . $defenseComments . '",
															 "' . $matchComments . '",
															 "' . $penalties . '",
															 "' . $cycleCount . '",
															 "' . $teleopPath . '")';
	$queryOutput = runQuery($queryString);
}









function leadScoutInput(
	$matchNum,
	$team1Off,
	$team2Off,
	$team3Off,
	$team1Def,
	$team2Def,
	$team3Def,
	$team1Dri,
	$team2Dri,
	$team3Dri
) {
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $leadScoutTable;
	$queryString = "REPLACE INTO `" . $leadScoutTable . '`(  `matchNum`,
															`team1Off`,
															`team2Off`,
															`team3Off`,
															`team1Def`,
															`team2Def`,
															`team3Def`,
															`team1Dri`,
															`team2Dri`,
															`team3Dri`)
															VALUES
															("' . $matchNum . '",
															"' . $team1Off . '",
															"' . $team2Off . '",
															"' . $team3Off . '",
															"' . $team1Def . '",
															"' . $team2Def . '",
															"' . $team3Def . '",
															"' . $team1Dri . '",
															"' . $team2Dri . '",
															"' . $team3Dri . '")';
	error_log($queryString);
	$queryOutput = runQuery($queryString);
}

function getTeamData($teamNumber)
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $pitScoutTable;
	global $matchScoutTable;
	global $leadScoutTable;
	$qs1 = "SELECT * FROM `" . $pitScoutTable . "` WHERE teamNumber = " . $teamNumber . "";
	$qs2 = "SELECT * FROM `" . $matchScoutTable . "`  WHERE teamNum = " . $teamNumber . "";
	$qs3 = "SELECT * FROM `" . $leadScoutTable . "`";

	$result = runQuery($qs1);
	$result2 = runQuery($qs2);
	$result3 = runQuery($qs3);
	$teamData = array();
	$pitExists = False;
	if ($result != FALSE) {
		// output data of each row
		foreach ($result as $row_key => $row) {
			array_push($teamData, $row["teamNumber"], $row["teamName"], $row["numBatteries"], $row["chargedBatteries"], $row["codeLanguage"], $row["pitComments"], $row["climbHelp"], array(), array());
			$pitExists = True;
		}
	}
	if (!$pitExists) {
		array_push($teamData, $teamNumber, 'NA', 'NA', 'NA', 'NA', 'NA', 'NA', array(), array());
	}
	if ($result2 != FALSE) {
		foreach ($result2 as $row_key => $row) {
			array_push($teamData[8], array(
				$row["user"], $row["ID"], $row["matchNum"],
				$row["teamNum"], $row["allianceColor"], $row["autoPath"],
				$row["crossLineA"], $row["upperGoal"], $row["upperGoalMiss"],
				$row["lowerGoal"], $row["lowerGoalMiss"], $row["upperGoalT"],
				$row["upperGoalMissT"],  $row["lowerGoalT"], $row["lowerGoalMissT"],
				$row["climb"], $row["climbTwo"], $row["climbThree"], $row["climbFour"], $row["issues"], $row["defenseBot"],
				$row["defenseComments"], $row["matchComments"], $row["penalties"], $row["cycleCount"], $row["teleopPath"]
			));
		}
	}
	if ($result3 != FALSE) {
		foreach ($result3 as $row_key => $row) {
			array_push($teamData[7], array(
				$row["matchNum"], $row["team1Off"], $row["team2Off"],
				$row["team3Off"], $row["team1Def"], $row["team2Def"], $row["team3Def"], $row["team1Dri"],
				$row["team2Dri"], $row["team3Dri"]
			));
		}
	}
	return ($teamData);
}





// The functions below output data per match
// These are used in graphs in the Match Strategy and Team Data Pages





function getAutoUpperGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][7];
		}

	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}

function getAutoLowerGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][9];
		}

	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}



function getAutoUpperGoalMiss($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][8];
		}

	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}


function getTeleopUpperGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][11];
		}

	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}


function getTeleopLowerGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][13];
		}
	} 

	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}


function getTeleopUpperGoalMiss($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][12];
		}

	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}


function getLowerGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][9] + $teamData[8][$i][13];
		}

	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}

function getClimb($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][15] + 2*$teamData[8][$i][16] + 3*$teamData[8][$i][17] + 4*$teamData[8][$i][18];
		}

	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}


function getUpperShotPercentage($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			if ((($teamData[8][$i][12]) + (($teamData[8][$i][11]) + ($teamData[8][$i][7]) + ($teamData[8][$i][8]))) != 0){
				$cubeGraphT[$teamData[8][$i][2]] = (100 * ((($teamData[8][$i][11]) + ($teamData[8][$i][7])) / (($teamData[8][$i][12]) + (($teamData[8][$i][11]) + ($teamData[8][$i][7]) + ($teamData[8][$i][8])))));
			} else {
				$cubeGraphT[$teamData[8][$i][2]] = 0;
			}
		}

	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}



function getAutoUpperShotPercentage($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = (($teamData[8][$i][7]) / (($teamData[8][$i][8])+($teamData[8][$i][7])));
		}
	}

	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}

function getScore($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cubeGraphT[$teamData[8][$i][2]] = ((4 * ($teamData[8][$i][7])) + (2 * ($teamData[8][$i][9])) + (2 * ($teamData[8][$i][11])) + ($teamData[8][$i][13]) + (4 * ($teamData[8][$i][15])) + (6 * ($teamData[8][$i][16])) + (10 * ($teamData[8][$i][17])) + (15 * ($teamData[8][$i][18])) + (5 * ($teamData[8][$i][6])));
		}
	}

	$out = array();
	for ($i = 0; $i != sizeof($matchN); $i++) {
		array_push($out, $cubeGraphT[$matchN[$i]]);
	}
	return ($out);
}





// The functions below are Averages






function getAvgUpperShotPercentage($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$upperGoalCount = 0;
	$upperGoalMissCount = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$upperGoalCount = $upperGoalCount + $teamData[8][$i][11] + $teamData[8][$i][7];
		}
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$upperGoalMissCount = $upperGoalMissCount + $teamData[8][$i][8] + $teamData[8][$i][12];
		}
		if (($upperGoalCount + $upperGoalMissCount) == 0) {
			return (0);
		}
	} 

	return (round((100 * ($upperGoalCount / ($upperGoalCount + $upperGoalMissCount))), 3));
}

function getAvgUpperGoalT($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$upperGoalCountT = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$upperGoalCountT = $upperGoalCountT + $teamData[8][$i][11];
			$matchCount++;
		}
	} 

	return (round(($upperGoalCountT / $matchCount), 3));
}

function getAvgLowerGoalT($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$lowerGoalCountT = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$lowerGoalCountT = $lowerGoalCountT + $teamData[8][$i][13];
			$matchCount++;
		}
	} 

	return ($lowerGoalCountT / $matchCount);
}

function getAvgUpperGoalMissT($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$upperGoalMissCountT = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$upperGoalMissCountT = $upperGoalMissCountT + $teamData[8][$i][12];
			$matchCount++;
		}
	} 

	return (round(($upperGoalMissCountT / $matchCount), 3));
}

function getAvgUpperGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$upperGoalCount = 0;
	$matchCount  = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$upperGoalCount = $upperGoalCount + $teamData[8][$i][7];
		$matchCount++;
	}

	return (round(($upperGoalCount / $matchCount), 3));
}

function getAvgLowerGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$lowerGoalCount = 0;
	$matchCount  = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$lowerGoalCount = $lowerGoalCount + $teamData[8][$i][9];
		$matchCount++;
	}

	return ($lowerGoalCount / $matchCount);
}


function getAvgClimb($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbSum = 0;
	$matchCount = 0;

	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$climbSum += $teamData[8][$i][15];
		$climbSum += $teamData[8][$i][16];
		$climbSum += $teamData[8][$i][17];
		$climbSum += $teamData[8][$i][18];
		$matchCount++;
	}

	return ($climbSum / $matchCount);
}

function getAvgPenalties($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$penalCount = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$penalCount = $penalCount + $teamData[8][$i][23];
			$matchCount++;
		}
	}

	return ($penalCount / $matchCount);
}


// Below, it considers $teamData[8][$i][24] a string. We found the length of the string and divided by 14 because there were 14 characters used to store data for each Cycle
function getAvgCycleCount($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$cycleCount = 0;
	$array = [];
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$cycleCount = $cycleCount + (strlen($teamData[8][$i][24])/14);
			$matchCount++;
		}
	} 

	return ($cycleCount/$matchCount);
}

function getAvgScore($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchCount  = 0;
	$Score = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$Score = $Score + ((4 * ($teamData[8][$i][7])) + (2 * ($teamData[8][$i][9])) + (2 * ($teamData[8][$i][11])) + ($teamData[8][$i][13]) + (4 * ($teamData[8][$i][15])) + (6 * ($teamData[8][$i][16])) + (10 * ($teamData[8][$i][17])) + (15 * ($teamData[8][$i][18])) + (5 * ($teamData[8][$i][6])));
			$matchCount++;
		}
	} 

	return ($Score / $matchCount);
}




// Get Max





function getMaxUpperGoalT($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$maxUpperGoalT = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		if ($maxUpperGoalT < $teamData[8][$i][11]) {
			$maxUpperGoalT = $teamData[8][$i][11];
		}
	}

	return ($maxUpperGoalT);
}

function getMaxLowerGoalT($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$maxLowerGoalT = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		if ($maxLowerGoalT < $teamData[8][$i][13]) {
			$maxLowerGoalT = $teamData[8][$i][13];
		}
	}

	return ($maxLowerGoalT);
}

function getMaxUpperGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$maxUpperGoal = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		if ($maxUpperGoal < $teamData[8][$i][7]) {
			$maxUpperGoal = $teamData[8][$i][7];
		}
	}

	return ($maxUpperGoal);
}

function getMaxLowerGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$maxLowerGoal = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		if ($maxLowerGoal < $teamData[8][$i][9]) {
			$maxLowerGoal = $teamData[8][$i][9];
		}
	}

	return ($maxLowerGoal);
}


// Get Alls


function matchNum($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchNum = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			array_push($matchNum, $teamData[8][$i][2]);
		}
	}

	sort($matchNum);
	return ($matchNum);
}

function getAllMatchData()
{
	global $matchScoutTable;
	$qs1 = "SELECT * FROM `" . $matchScoutTable . "`";
	return runQuery($qs1);
}

function getAllLeadScoutData()
{
	global $leadScoutTable;
	$qs1 = "SELECT * FROM `" . $leadScoutTable . "`";
	return runQuery($qs1);
}



// Get Total/ Ability



function getTotalClimb($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$climbCount = $climbCount + $teamData[8][$i][15];
		$climbCount = $climbCount + $teamData[8][$i][16];
		$climbCount = $climbCount + $teamData[8][$i][17];
		$climbCount = $climbCount + $teamData[8][$i][18];
	}

	return ($climbCount);
}

function getTotalAuto($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$auto = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$auto = $auto + $teamData[8][$i][6];

	}
	
	return ($auto);
}

function getAuto($teamNumber)
{
	$auto = getTotalAuto($teamNumber);
	if ($auto == 0){
		return "No/Haven't done Yet";
	} else{
		return "Yes";
	}
}

function getAutoValue($teamNumber)
{
	$auto = getTotalAuto($teamNumber);
	if ($auto == 0){
		return 0;
	} else{
		return 1;
	}
}


function getClimbAbility($teamNumber)
{
	$climbCount = getTotalSingleClimb($teamNumber) + getTotalDoubleClimb($teamNumber) + getTotalTripleClimb($teamNumber) + getTotalQuadClimb($teamNumber);
	if ($climbCount == 0){
		return "No/Haven't done Yet";
	} else{
		return "Yes";
	}
}


function getTotalUpperGoal($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$upperGoal = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$upperGoal = $upperGoal + $teamData[8][$i][7];
		$upperGoal = $upperGoal + $teamData[8][$i][11];
	}
	
	return ($upperGoal);
}



function getTotalSingleClimb($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$climbCount = $climbCount + $teamData[8][$i][15];
	}
	
	return ($climbCount);
}

function getSingleClimbPercent($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$climbCount = $climbCount + $teamData[8][$i][15];
			$matchCount++;
		}
	}

	return (($climbCount / $matchCount));
}

function getTotalDoubleClimb($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$climbCount = $climbCount + $teamData[8][$i][16];
	}
	
	return ($climbCount);
}

function getDoubleClimbPercent($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$climbCount = $climbCount + $teamData[8][$i][16];
			$matchCount++;
		}
	}

	return (($climbCount / $matchCount));
}

function getTotalTripleClimb($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$climbCount = $climbCount + $teamData[8][$i][17];
	}
	
	return ($climbCount);
}

function getTripleClimbPercent($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$climbCount = $climbCount + $teamData[8][$i][17];
			$matchCount++;
		}
	}

	return (($climbCount / $matchCount));
}

function getTotalQuadClimb($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$climbCount = $climbCount + $teamData[8][$i][18];
	}
	
	return ($climbCount);
}

function getQuadClimbPercent($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$climbCount = 0;
	$matchCount  = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$climbCount = $climbCount + $teamData[8][$i][18];
			$matchCount++;
		}
	}

	return (($climbCount / $matchCount));
}

function getHighestClimb($teamNumber)
{
	if(getTotalQuadClimb($teamNumber) != 0){
		return ("Traversal");
	} else if(getTotalTripleClimb($teamNumber) != 0){
		return ("High");
	} else if(getTotalDoubleClimb($teamNumber) != 0){
		return ("Medium");
	} else if(getTotalSingleClimb($teamNumber) != 0){
		return ("Medium");
	} else{
		return ("No Climb");
	}
	
}


function getTotalScore($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchCount  = 0;
	$Score = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$Score = $Score + ((4 * ($teamData[8][$i][7])) + (2 * ($teamData[8][$i][9])) + (2 * ($teamData[8][$i][11])) + ($teamData[8][$i][13]) + (4 * ($teamData[8][$i][15])) + (6 * ($teamData[8][$i][16])) + (10 * ($teamData[8][$i][17])) + (15 * ($teamData[8][$i][18])) + (5 * ($teamData[8][$i][6])));
			$matchCount++;
		}
	} 

	return ($Score);
}

function getTotalDefense($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$defenseCount = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$defenseCount = $defenseCount + $teamData[8][$i][20];
		}
	} 

	return ($defenseCount);
}


// Ranks




function getAvgDriveRank($teamNumber)
{
	$result = getAllLeadScoutData();
	$driveRankSum = 0;
	$matchCount = 0;
	foreach ($result as $row_key => $row) {
		foreach ($row as $key => $value) {
			$num = $key;
			if ($value == $teamNumber) {
				if ($key == "team1Dri") {
					$driveRankSum += 1;
					$matchCount++;
				} else if ($key == "team2Dri") {
					$driveRankSum += 2;
					$matchCount++;
				} else if ($key == "team3Dri") {
					$driveRankSum += 3;
					$matchCount++;
				}
			}
		}
	}
	if ($matchCount == 0) {
		$matchCount = 1;
	} else {
		$matchCount = $matchCount;
	}

	return ($driveRankSum / $matchCount);
}

function getAvgDefenseRank($teamNumber)
{
	$result = getAllLeadScoutData();
	$defenseRankSum = 0;
	$matchCount = 0;
	foreach ($result as $row_key => $row) {
		foreach ($row as $key => $value) {
			$num = $key;
			if ($value == $teamNumber) {
				if ($key == "team1Def") {
					$defenseRankSum += 1;
					$matchCount++;
				} else if ($key == "team2Def") {
					$defenseRankSum += 2;
					$matchCount++;
				} else if ($key == "team3Def") {
					$defenseRankSum += 3;
					$matchCount++;
				}
			}
		}
	}
	if ($matchCount == 0) {
		$matchCount = 1;
	} else {
		$matchCount = $matchCount;
	}

	return ($defenseRankSum / $matchCount);
}

function getAvgOffenseRank($teamNumber)
{
	$result = getAllLeadScoutData();
	$offenseRankSum = 0;
	$matchCount = 0;
	foreach ($result as $row_key => $row) {
		foreach ($row as $key => $value) {
			$num = $key;
			if ($value == $teamNumber) {
				if ($key == "team1Off") {
					$offenseRankSum += 1;
					$matchCount++;
				} else if ($key == "team2Off") {
					$offenseRankSum += 2;
					$matchCount++;
				} else if ($key == "team3Off") {
					$offenseRankSum += 3;
					$matchCount++;
				}
			}
		}
	}
	if ($matchCount == 0) {
		$matchCount = 1;
	} else {
		$matchCount = $matchCount;
	}

	return ($offenseRankSum / $matchCount);
}



// Comments



function defenseComments($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$defenseComments = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			array_push($defenseComments, $teamData[8][$i][21]);
		}
	}

	return ($defenseComments);
}

function matchComments($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchComments = array();
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			array_push($matchComments, $teamData[8][$i][22]);
		}
	}

	return ($matchComments);
}








function getPickList($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$pointCal = 0;
	$matchCount = 0;
	if ($teamData[8] != null){
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$pointCal = ($pointCal - (0.125 * ($teamData[8][$i][8])));
			$pointCal = ($pointCal - (0.25 * ($teamData[8][$i][10])));
			$pointCal = ($pointCal - (0.25 * ($teamData[8][$i][12])));
			$pointCal = ($pointCal - (0.5 * ($teamData[8][$i][14])));

			$pointCal = ($pointCal + (2 * ($teamData[8][$i][7])));
			$pointCal = ($pointCal + (0.5 * ($teamData[8][$i][9])));

			$pointCal = ($pointCal + (1 * ($teamData[8][$i][11])));
			$pointCal = ($pointCal + (0.25 * ($teamData[8][$i][13])));

			$pointCal = ($pointCal + (0.5 * ($teamData[8][$i][15])));
			$pointCal = ($pointCal + (1 * ($teamData[8][$i][16])));
			$pointCal = ($pointCal + (3 * ($teamData[8][$i][17])));
			$pointCal = ($pointCal + (9 * ($teamData[8][$i][18])));

			$pointCal = ($pointCal + (0.25 * ($teamData[8][$i][6])));
			$matchCount++;
		}
	}

	return (round(($pointCal / $matchCount), 3));
}




// Validation and COPR Functions



function getCorrectData($match, $alliance, $detail)
{
	// ************* Call API:
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.thebluealliance.com/api/v3/match/" . $match . "?X-TBA-Auth-Key=VPexr6soymZP0UMtFw2qZ11pLWcaDSxCMUYOfMuRj5CQT3bzoExsUGHuO1JvyCyU");
	curl_setopt($ch, CURLOPT_HEADER, 0);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
	$json = curl_exec($ch);
	curl_close ($ch);
	$data = json_decode($json,true);

	return $data["score_breakdown"]["$alliance"]["$detail"];
	
	
}

function getMatchAlliance($match, $alliance, $team)
{
	// ************* Call API:
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.thebluealliance.com/api/v3/match/" . $match . "?X-TBA-Auth-Key=VPexr6soymZP0UMtFw2qZ11pLWcaDSxCMUYOfMuRj5CQT3bzoExsUGHuO1JvyCyU");
	curl_setopt($ch, CURLOPT_HEADER, 0);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
	$json = curl_exec($ch);
	curl_close ($ch);
	$data = json_decode($json,true);

	return substr($data["alliances"]["$alliance"]["team_keys"]["$team"],3);
	
	
}

function getThreePointNew($teamNumber)
{
	$command = escapeshellcmd('python3 threecalcufinal.py');
	$output = shell_exec($command);

	$csvFile = file('ThreeOPR.txt');
    $data = array();
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }

	for($x = 0; $x < sizeof($data); $x++){
		$word = $data[$x][0];
		$word = substr($word, 3);
		if ($word == $teamNumber){
			return round($data[$x][1],2);
		}
	}
}

function getUpperTotal($teamNumber)
{
	$command = escapeshellcmd('python3 uppercalcufinal.py');
	$output = shell_exec($command);

	$csvFile = file('upperOPR.txt');
    $data = array();
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }

	for($x = 0; $x < sizeof($data); $x++){
		$word = $data[$x][0];
		$word = substr($word, 3);
		if ($word == $teamNumber){
			return round($data[$x][1],2);
		}
	}
}


function getOPR($teamNumber)
{
	$command = escapeshellcmd('python3 oprcalcufinal.py');
	$output = shell_exec($command);

	$csvFile = file('OPR.txt');
    $data = array();
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }

	for($x = 0; $x < sizeof($data); $x++){
		$word = $data[$x][0];
		$word = substr($word, 3);
		if ($word == $teamNumber){
			return round($data[$x][1],2);
		}
	}
}