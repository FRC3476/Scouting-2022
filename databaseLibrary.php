<?php
include("databaseName.php");
require_once('tbaAPI.php');
require_once("qualRankGen.php");
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
	global $betTable;
	global $leadScoutTable;
	global $pickListTable;
	global $eloRanking;
	//Establish Connection
	try {
		$conn = connectToDB();
	} catch (Exception $e) {
		error_log("CREATING DB");
		createDB();
		$conn = connectToDB();
	}
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
function createTBATable($tbaTableName)
{
	$conn = connectToDB();
	global $dbname;


	$query = "CREATE TABLE " . $dbname . "." . $tbaTableName . " (
        requestURI VARCHAR(100) NOT NULL PRIMARY KEY,
        expiryTime BIGINT NOT NULL,
        response MEDIUMTEXT NOT NULL
    )";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("createTBATable Error: CREATE TABLE tbatable query failed.");
	}
}

function createTables()
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $pitScoutTable;
	global $matchScoutTable;
	global $betTable;
	global $pickListTable;
	global $leadScoutTable;
	global $$sorting_items;
	global $eloRanking;
	global $sortablePickTable;
	$conn = connectToDB();

	$query = "CREATE TABLE " . $dbname . "." . $leadScoutTable . " (
			matchkey VARCHAR(60) NOT NULL,
      teamrank MEDIUMTEXT NOT NULL
		)";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE leadScoutTable query failed.");
	}

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
			teleopPath LONGTEXT NOT NULL,
			doNotPick INT(11) NOT NULL
		)";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE matchScoutTable query failed.");
	}


	$query = "CREATE TABLE " . $dbname . "." . $betTable . " (
		matchNum INT(11) NOT NULL,
		RedScorePredict TEXT NOT NULL,
		BlueScorePredict TEXT NOT NULL,
		TotalAutoRed TEXT NOT NULL,
		TotalAutoBlue TEXT NOT NULL,
		Winner TEXT NOT NULL,
		name TEXT NOT NULL,
		ID VARCHAR(50) NOT NULL PRIMARY KEY
	)";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE Bet Table query failed.");
	}

	$query = "CREATE TABLE " . $dbname . "." . $sortablePickTable . " (
		allTeams LONGTEXT NOT NULL,
		attackTeams LONGTEXT NOT NULL,
		defenseTeams LONGTEXT NOT NULL,
		dnpTeams LONGTEXT NOT NULL
	)";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE Sortable Pick query failed.");
	}

	$query = "CREATE TABLE " . $dbname . "." . $pickListTable . " (
		team1 VARCHAR(50) NOT NULL,
		team2 VARCHAR(50) NOT NULL,
		equal VARCHAR(50) NOT NULL
	)";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE pickList Table query failed.");
	}

	$query = "CREATE TABLE " . $dbname . "." . $eloRanking . " (
		team VARCHAR(50) NOT NULL PRIMARY KEY,
		eloScore INT(11) NOT NULL
	)";
	$statement = $conn->prepare($query);
	if (!$statement->execute()) {
		throw new Exception("constructDatabase Error: CREATE TABLE elo Table query failed.");
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

function leadScoutInput($matchKey, $teamRank)
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $leadScoutTable;

	$data = array();
	$data["matchkey"] = $matchKey;
	$data["teamrank"] = $teamRank;

	$conn = connectToDB();
	$sql = "INSERT INTO " . $leadScoutTable . "(matchkey, teamrank) VALUES(:matchkey, :teamrank)";
	$prepared_statement = $conn->prepare($sql);
	$prepared_statement->execute($data);
}

function betInput($matchNum, $RedScorePredict, $BlueScorePredict, $TotalAutoRed, $TotalAutoBlue, $Winner, $name, $ID)
{
	global $betTable;
	$queryString = "REPLACE INTO `" . $betTable . "` (`matchNum`, `RedScorePredict`, `BlueScorePredict`,`TotalAutoRed`, `TotalAutoBlue`, `Winner`, `name`, `ID`)";
	$queryString = $queryString . ' VALUES ("' . $matchNum . '", "' . $RedScorePredict . '", "' . $BlueScorePredict . '", "' . $TotalAutoRed . '", "' . $TotalAutoBlue . '", "' . $Winner . '", "' . $name . '", "' . $ID . '")';
	$queryOutput = runQuery($queryString);
}

function sortableInput($allTeams, $attackTeams, $defenseTeams, $dnpTeams)
{
	global $sortablePickTable;
	$queryString = "REPLACE INTO `" . $sortablePickTable . "` (`allTeams`, `attackTeams`, `defenseTeams`,`TotalAutoRed`, `dnpTeams`)";
	$queryString = $queryString . ' VALUES ("' . $allTeams . '", "' . $attackTeams . '", "' . $defenseTeams . '", "' . $dnpTeams . '")';
	$queryOutput = runQuery($queryString);
}

function pickListInput($team1, $team2, $equal)
{
	global $pickListTable;
	$queryString = "REPLACE INTO `" . $pickListTable . "` (`team1`, `team2`, `equal`)";
	$queryString = $queryString . ' VALUES ("' . $team1 . '", "' . $team2 . '", "' . $equal . '")';
	$queryOutput = runQuery($queryString);
	updateElo($team1, $team2, $equal);
}

function eloInput($team, $eloScore)
{
	global $eloRanking;
	$queryString = "REPLACE INTO `" . $eloRanking . "` (`team`, `eloScore`)";
	$queryString = $queryString . ' VALUES ("' . $team . '", "' . $eloScore . '")';
	$queryOutput = runQuery($queryString);
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
	$teleopPath,
	$doNotPick
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
															 `teleopPath`,
															 `doNotPick`)
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
															 "' . $teleopPath . '",
															 "' . $doNotPick . '")';
	$queryOutput = runQuery($queryString);
}

//Input- getTeamList, accesses match scout table and gets team numbers from it.
//Output- array, list of teams in teamNumber column of pitscout table.

function getElo($teamNumber)
{
	global $eloRanking;
	$qs1 = "SELECT eloScore FROM `" . $eloRanking . "` WHERE team = " . $teamNumber . "";
	$result = runQuery($qs1);
	$teams = array();
	foreach ($result as $row_key => $row) {
		if (!in_array($row["eloScore"], $teams)) {
			array_push($teams, $row["eloScore"]);
		}
	}
	return ($teams[0]);
}

function eloChange($teamNumber, $eloScore)
{
	global $eloRanking;
	$qs1 = "UPDATE `" . $eloRanking . "` SET eloScore = " . $eloScore . " WHERE team = " . $teamNumber;
	$result = runQuery($qs1);
}

function getTeamList($min = -1, $max = 1000)
{
	global $matchScoutTable;
	$queryStringTwo = "SELECT `teamNum` FROM `" . $matchScoutTable . "`  WHERE matchNum >= " . $min . " AND matchNum <= " . $max . "";
	$resultTwo = runQuery($queryStringTwo);
	$teams = array();

	foreach ($resultTwo as $row_key => $row) {
		if (!in_array($row["teamNum"], $teams)) {
			array_push($teams, $row["teamNum"]);
		}
	}
	return ($teams);
}

function getUserList()
{
	global $betTable;
	$queryStringTwo = "SELECT `name` FROM `" . $betTable . "`";
	$resultTwo = runQuery($queryStringTwo);
	$names = array();

	foreach ($resultTwo as $row_key => $row) {
		if (!in_array($row["name"], $names)) {
			array_push($names, $row["name"]);
		}
	}
	return ($names);
}

function getAllTeamAverageData()
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $matchScoutTable;
	$qs = "SELECT * FROM `" . $matchScoutTable . "`";
	$result = runQuery($qs);
	$teamData = array();
	$teamList = array();
	foreach ($result as $row_key => $row) {

		$teamNum = $row["teamNum"];
		if (!isset($teamList[$teamNum])) {
			$teamList[$teamNum] = 1;
			$teamData[$teamNum] = array();
			$teamData[$teamNum]['matchCount'] = 0;
			$teamData[$teamNum]['ballsScored'] = 0;
			$teamData[$teamNum]['autoPoints'] = 0;
			$teamData[$teamNum]['teleopPoints'] = 0;
			$teamData[$teamNum]['endgamePoints'] = 0;
			$teamData[$teamNum]['totalPoints'] = 0;
		}

		$autoPoints = (($row['crossLineA'] == 1) ? 2 : 0) + ($row['upperGoal'] * 4) + ($row['lowerGoal'] * 2);
		$teleopPoints = ($row['upperGoalT'] * 2) + ($row['lowerGoalT'] * 1);
		$endgamePoints = 0;
		if ($row['climb']) {
			$endgamePoints = 4;
		} else if ($row['climbTwo']) {
			$endgamePoints = 6;
		} else if ($row['climbThree']) {
			$endgamePoints = 10;
		} else if ($row['climbFour']) {
			$endgamePoints = 15;
		}
		$totalPoints = $autoPoints + $teleopPoints + $endgamePoints;
		$ballsScored = $row['upperGoal'] + $row['lowerGoal'] + $row['upperGoalT'] + $row['lowerGoalT'];

		$teamData[$teamNum]['matchCount'] += 1;
		$teamData[$teamNum]['ballsScored'] += $ballsScored;
		$teamData[$teamNum]['autoPoints'] += $autoPoints;
		$teamData[$teamNum]['teleopPoints'] += $teleopPoints;
		$teamData[$teamNum]['endgamePoints'] += $endgamePoints;
		$teamData[$teamNum]['totalPoints'] += $totalPoints;
	}

	foreach ($teamList as $team => $teamRow) {
		$teamData[$team]['ballsScored']   = $teamData[$team]['ballsScored']   / $teamData[$team]['matchCount'];
		$teamData[$team]['autoPoints']    = $teamData[$team]['autoPoints']    / $teamData[$team]['matchCount'];
		$teamData[$team]['teleopPoints']  = $teamData[$team]['teleopPoints']  / $teamData[$team]['matchCount'];
		$teamData[$team]['endgamePoints'] = $teamData[$team]['endgamePoints'] / $teamData[$team]['matchCount'];
		$teamData[$team]['totalPoints']   = $teamData[$team]['totalPoints'] / $teamData[$team]['matchCount'];
	}

	return $teamData;
}

function getTeamData($teamNumber, $min = -1, $max = 1000)
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $pitScoutTable;
	global $matchScoutTable;
	global $leadScoutTable;
	$qs1 = "SELECT * FROM `" . $pitScoutTable . "` WHERE teamNumber = " . $teamNumber . "";
	$qs2 = "SELECT * FROM `" . $matchScoutTable . "`  WHERE teamNum = " . $teamNumber . " AND matchNum >= " . $min . " AND matchNum <= " . $max . "";
	//echo "<script>console.log('".$qs2."');</script>";
	// $qs3 = "SELECT * FROM `" . $leadScoutTable . "`";

	$result = runQuery($qs1);
	$result2 = runQuery($qs2);
	// $result3 = runQuery($qs3);
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
				$row["defenseComments"], $row["matchComments"], $row["penalties"], $row["cycleCount"], $row["teleopPath"], $row["doNotPick"]
			));
		}
	}
	return ($teamData);
}

function getBetData($user)
{
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $betTable;
	$qs1 = "SELECT * FROM " . $betTable . " WHERE name = '" . $user . "'";

	$result = runQuery($qs1);
	$betData = array();
	if ($result != FALSE) {
		foreach ($result as $row_key => $row) {
			array_push($betData, array(
				$row["matchNum"], $row["RedScorePredict"], $row["BlueScorePredict"],
				$row["TotalAutoRed"], $row["TotalAutoBlue"], $row["Winner"],
				$row["name"], $row["ID"]
			));
		}
	}
	return ($betData);
}


// The functions below output data per match
// These are used in graphs in the Match Strategy and Team Data Pages



function getEvent()
{

	return ("2022cabl_qm");
}

function getYourTeam()
{

	return ("frc3476");
}

function getEventRaw()
{

	$event = getEvent();
	$event = substr($event, 0, -3);
	return $event;
}

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

function Standardize($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$cubeGraphT[$teamData[8][$i][2]] = 20;
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
	if ($teamData[8] != null) {
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
		$cubeGraphT[$teamData[8][$i][2]] = $teamData[8][$i][15] + 2 * $teamData[8][$i][16] + 3 * $teamData[8][$i][17] + 4 * $teamData[8][$i][18];
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
		if ((($teamData[8][$i][12]) + (($teamData[8][$i][11]) + ($teamData[8][$i][7]) + ($teamData[8][$i][8]))) != 0) {
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

function getScore($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchN = matchNum($teamNumber);
	$cubeGraphT = array();
	if ($teamData[8] != null) {
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






function getAvgUpperShotPercentage($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$upperGoalCount = 0;
	$upperGoalMissCount = 0;
	if ($teamData[8] != null) {
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

function getAvgUpperGoalT($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$upperGoalCountT = 0;
	$matchCount  = 0;
	if ($teamData[8] != null) {
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$upperGoalCountT = $upperGoalCountT + $teamData[8][$i][11];
			$matchCount++;
		}
	}

	return (round(($upperGoalCountT / $matchCount), 3));
}

function getAvgLowerGoalT($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$lowerGoalCountT = 0;
	$matchCount  = 0;
	if ($teamData[8] != null) {
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$lowerGoalCountT = $lowerGoalCountT + $teamData[8][$i][13];
			$matchCount++;
		}
	}

	return ($lowerGoalCountT / $matchCount);
}

function getAvgUpperGoal($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$upperGoalCount = 0;
	$matchCount  = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$upperGoalCount = $upperGoalCount + $teamData[8][$i][7];
		$matchCount++;
	}

	return (round(($upperGoalCount / $matchCount), 3));
}

function getAvgLowerGoal($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$lowerGoalCount = 0;
	$matchCount  = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$lowerGoalCount = $lowerGoalCount + $teamData[8][$i][9];
		$matchCount++;
	}

	return ($lowerGoalCount / $matchCount);
}


function getAvgClimb($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
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
	if ($teamData[8] != null) {
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$penalCount = $penalCount + $teamData[8][$i][23];
			$matchCount++;
		}
	}

	return ($penalCount / $matchCount);
}

function getAvgScore($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$matchCount  = 0;
	$Score = 0;
	if ($teamData[8] != null) {
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$Score = $Score + ((4 * ($teamData[8][$i][7])) + (2 * ($teamData[8][$i][9])) + (2 * ($teamData[8][$i][11])) + ($teamData[8][$i][13]) + (4 * ($teamData[8][$i][15])) + (6 * ($teamData[8][$i][16])) + (10 * ($teamData[8][$i][17])) + (15 * ($teamData[8][$i][18])) + (2 * ($teamData[8][$i][6])));
			$matchCount++;
		}
	}

	return ($Score / $matchCount);
}


// Get Max





function getMaxUpperGoalT($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$maxUpperGoalT = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		if ($maxUpperGoalT < $teamData[8][$i][11]) {
			$maxUpperGoalT = $teamData[8][$i][11];
		}
	}

	return ($maxUpperGoalT);
}

function getMaxLowerGoalT($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$maxLowerGoalT = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		if ($maxLowerGoalT < $teamData[8][$i][13]) {
			$maxLowerGoalT = $teamData[8][$i][13];
		}
	}

	return ($maxLowerGoalT);
}

function getMaxUpperGoal($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$maxUpperGoal = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		if ($maxUpperGoal < $teamData[8][$i][7]) {
			$maxUpperGoal = $teamData[8][$i][7];
		}
	}

	return ($maxUpperGoal);
}

function getMaxLowerGoal($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
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
	if ($teamData[8] != null) {
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

function getRawLeadScoutData()
{
	global $leadScoutTable;
	$qs1 = "SELECT * FROM `" . $leadScoutTable . "`";
	return runQuery($qs1);
}

function getLeadScoutData()
{
	$rawRankData = getRawLeadScoutData();
	$rankData = array();
	$dataSize = sizeof($rawRankData);
	for ($i = 0; $i < $dataSize; $i++) {
		array_push($rankData, json_decode($rawRankData[$i]["teamrank"], True));
	}
	return $rankData;
}

function getLeadScoutELODict()
{
	$qrg = new qualRankGen(getLeadScoutData());
	return $qrg->raw_votes_to_elo_map(30);
}



function getAllPicklistData()
{
	global $pickListTable;
	$qs1 = "SELECT * FROM `" . $pickListTable . "`";
	return runQuery($qs1);
}

function getAllElo()
{
	global $eloRanking;
	$qs1 = "SELECT * FROM `" . $eloRanking . "`";
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

function getAutoValue($teamNumber)
{
	$auto = getTotalAuto($teamNumber);
	if ($auto == 0) {
		return 0;
	} else {
		return 1;
	}
}

function getPit($teamNumber)
{
	global $pitScoutTable;
	$qs1 = "SELECT * FROM `" . $pitScoutTable . "` WHERE teamNumber = " . $teamNumber . "";
	$result = runQuery($qs1);
	$pitExists = False;
	if ($result != FALSE) {
		$pitExists = True;
		return ("Yes");
	}
	if (!$pitExists) {
		return ("No");
	}
}

function getPicture($teamNumber)
{
	if (file_exists("uploads/" . $teamNumber . "-0.jpg")) {
		return ("Yes");
	} else if (file_exists("uploads/" . $teamNumber . "-0.png")) {
		return ("Yes");
	} else if (file_exists("uploads/" . $teamNumber . "-0.jpeg")) {
		return ("Yes");
	} else {
		return ("No");
	}
}

function getClimbAbility($teamNumber)
{
	$climbCount = getTotalSingleClimb($teamNumber) + getTotalDoubleClimb($teamNumber) + getTotalTripleClimb($teamNumber) + getTotalQuadClimb($teamNumber);
	if ($climbCount == 0) {
		return "No/Haven't done Yet";
	} else {
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

function getSingleClimbPercent($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$climbCount = 0;
	$matchCount  = 0;
	if ($teamData[8] != null) {
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

function getDoubleClimbPercent($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$climbCount = 0;
	$matchCount  = 0;
	if ($teamData[8] != null) {
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

function getTripleClimbPercent($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$climbCount = 0;
	$matchCount  = 0;
	if ($teamData[8] != null) {
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

function getQuadClimbPercent($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$climbCount = 0;
	$matchCount  = 0;
	if ($teamData[8] != null) {
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$climbCount = $climbCount + $teamData[8][$i][18];
			$matchCount++;
		}
	}

	return (($climbCount / $matchCount));
}

function getHighestClimb($teamNumber)
{
	if (getTotalQuadClimb($teamNumber) != 0) {
		return ("Traversal");
	} else if (getTotalTripleClimb($teamNumber) != 0) {
		return ("High");
	} else if (getTotalDoubleClimb($teamNumber) != 0) {
		return ("Medium");
	} else if (getTotalSingleClimb($teamNumber) != 0) {
		return ("Low");
	} else {
		return ("No Climb");
	}
}


function getTotalScore($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$matchCount  = 0;
	$Score = 0;
	if ($teamData[8] != null) {
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$Score = $Score + ((4 * ($teamData[8][$i][7])) + (2 * ($teamData[8][$i][9])) + (2 * ($teamData[8][$i][11])) + ($teamData[8][$i][13]) + (4 * ($teamData[8][$i][15])) + (6 * ($teamData[8][$i][16])) + (10 * ($teamData[8][$i][17])) + (15 * ($teamData[8][$i][18])) + (5 * ($teamData[8][$i][6])));
			$matchCount++;
		}
	}

	return ($Score);
}

function getBetScore($user)
{
	$bet = getbetData($user);
	$event = getEvent();
	$Score = 0;

	if ($bet != null) {
		for ($i = 0; $i != sizeof($bet); $i++) {
			$match = $bet[$i][0];
			$eventMatch = $event . $match;
			$tba = getTBAHandler();
			$data = $tba->makeDBCachedCall('/match/' . $eventMatch)['response'];
			$blueAuto = $data["score_breakdown"]["blue"]["autoCargoTotal"];
			$redAuto = $data["score_breakdown"]["red"]["autoCargoTotal"];
			$alliance = $data["winning_alliance"];
			if ($alliance == "") {
				$alliance = "Tie";
			}
			$blueEndgame = $data["score_breakdown"]["blue"]["endgamePoints"];
			$redEndgame = $data["score_breakdown"]["red"]["endgamePoints"];
			if ($blueEndgame == $redEndgame) {
				$endgameWinner = "equal";
			} else if ($blueEndgame > $redEndgame) {
				$endgameWinner = "blue";
			} else if ($blueEndgame < $redEndgame) {
				$endgameWinner = "red";
			}
			$bluePoints = $data["score_breakdown"]["blue"]["totalPoints"];
			$redPoints = $data["score_breakdown"]["red"]["totalPoints"];
			$margin = abs($redPoints - $bluePoints);
			if ($bet[$i][1] == $margin) {
				$Score += 5;
			}
			if ($bet[$i][2] == $endgameWinner) {
				$Score += 2;
			}
			if ($bet[$i][3] == $redAuto) {
				$Score += 1;
			}
			if ($bet[$i][4] == $blueAuto) {
				$Score += 1;
			}
			if ($bet[$i][5] == $alliance) {
				$Score += 2;
			}
		}
	}

	return ($Score);
}

function getBetAvg($user)
{
	$bet = getbetData($user);
	$event = getEvent();
	$Score = 0;
	$input = 0;

	if ($bet != null) {
		for ($i = 0; $i != sizeof($bet); $i++) {
			$match = $bet[$i][0];
			$eventMatch = $event . $match;
			$tba = getTBAHandler();
			$data = $tba->makeDBCachedCall('/match/' . $eventMatch)['response'];

			$blueAuto = $data["score_breakdown"]["blue"]["autoCargoTotal"];
			$redAuto = $data["score_breakdown"]["red"]["autoCargoTotal"];
			$alliance = $data["winning_alliance"];
			$blueEndgame = $data["score_breakdown"]["blue"]["endgamePoints"];
			$redEndgame = $data["score_breakdown"]["red"]["endgamePoints"];
			if ($blueEndgame == $redEndgame) {
				$endgameWinner = "equal";
			} else if ($blueEndgame > $redEndgame) {
				$endgameWinner = "blue";
			} else if ($blueEndgame < $redEndgame) {
				$endgameWinner = "red";
			}
			$bluePoints = $data["score_breakdown"]["blue"]["totalPoints"];
			$redPoints = $data["score_breakdown"]["red"]["totalPoints"];
			$margin = abs($redPoints - $bluePoints);
			if ($bet[$i][1] == $margin) {
				$Score += 5;
			}
			if ($bet[$i][2] == $endgameWinner) {
				$Score += 2;
			}
			if ($bet[$i][3] == $redAuto) {
				$Score += 1;
			}
			if ($bet[$i][4] == $blueAuto) {
				$Score += 1;
			}
			if ($bet[$i][5] == $alliance) {
				$Score += 2;
			}
			$input += 1;
		}
	}

	return ($Score / $input);
}

function getTotalDefense($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$defenseCount = 0;
	if ($teamData[8] != null) {
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			$defenseCount = $defenseCount + $teamData[8][$i][20];
		}
	}

	return ($defenseCount);
}

function getTotalDNP($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$dnp = 0;
	for ($i = 0; $i != sizeof($teamData[8]); $i++) {
		$dnp = $dnp + $teamData[8][$i][26];
	}

	return ($dnp);
}

// Ranks


function getAvgDriveRank($teamNumber, $min = -1, $max = 1000)
{
	$result = getRawLeadScoutData();
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

function getAllianceRankPoints($teamNumber, $min = -1, $max = 1000)
{
	$result = getRawLeadScoutData();
	$driveRankSum = 0;
	$matchCount = 0;
	foreach ($result as $row_key => $row) {
		foreach ($row as $key => $value) {
			$num = $key;
			if ($value == $teamNumber) {
				if ($key == "team1Dri") {
					$driveRankSum += 3;
					$matchCount++;
				} else if ($key == "team2Dri") {
					$driveRankSum += 2;
					$matchCount++;
				} else if ($key == "team3Dri") {
					$driveRankSum += 1;
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

	return ($driveRankSum);
}

function getScoutGeneratedPicklist($teamNumber)
{
	$result = getAllPicklistData();
	$score = 0;
	$matchCount = 0;
	foreach ($result as $row_key => $row) {
		foreach ($row as $key => $value) {
			$num = $key;
			if ($value == $teamNumber) {
				if ($key == "team1") {
					$score += 1;
				} else if ($key == "team2") {
					$score -= 1;
				}
			}
		}
	}
	return ($score);
}

function updateElo($team1, $team2, $equal)
{
	$eloCheck = getAllElo();
	if ($eloCheck == null) {
		$teamList = getEventTeams();
		foreach ($teamList as $teamNumber) {
			eloInput($teamNumber, 1000);
		}
	}

	if ($equal == 0) {
		$team1Elo = getElo($team1);
		$team2Elo = getElo($team2);

		$dif = $team1Elo - $team2Elo;

		if ($dif < -40) {
			$weight = 40;
		} else if ($dif < 0) {
			$weight = 30;
		} else if ($dif == 0) {
			$weight = 30;
		}
		if ($dif > 50) {
			$weight = 10;
		} else if ($dif > 0) {
			$weight = 20;
		}

		if ($dif >= 0) {
			$expecScoreteam1 = ($weight * (1 - (1 / (1 + (10 ^ (($team1Elo - $team2Elo) / 400))))));
			$expecScoreteam2 = ($weight * (0 - (1 / (1 + (10 ^ (($team2Elo - $team1Elo) / 400))))));
			$team1New = $team1Elo + $expecScoreteam1;
			$team2New = $team2Elo - $expecScoreteam2;
		}

		eloChange($team1, $team1New);
		eloChange($team2, $team2New);
	} else if ($equal == 1) {
		$team1Elo = getElo($team1);
		$team2Elo = getElo($team2);

		$dif = $team2Elo - $team1Elo;

		if ($dif < -40) {
			$weight = 40;
		} else if ($dif < 0) {
			$weight = 30;
		} else if ($dif == 0) {
			$weight = 30;
		}
		if ($dif > 50) {
			$weight = 10;
		} else if ($dif > 0) {
			$weight = 20;
		}

		if ($dif >= 0) {
			$expecScoreteam1 = ($weight * (1 - (1 / (1 + (10 ^ (($team1Elo - $team2Elo) / 400))))));
			$expecScoreteam2 = ($weight * (0 - (1 / (1 + (10 ^ (($team2Elo - $team1Elo) / 400))))));
			$team1New = $team1Elo - $expecScoreteam1;
			$team2New = $team2Elo + $expecScoreteam2;
		}

		eloChange($team1, $team1New);
		eloChange($team2, $team2New);
	} else if ($equal == 2) {
		$team1Elo = getElo($team1);
		$team2Elo = getElo($team2);

		$dif = $team1Elo - $team2Elo;

		if ($dif < -40) {
			$weight = 15;
		} else if ($dif < 0) {
			$weight = 8;
		} else if ($dif == 0) {
			$weight = 5;
		}
		if ($dif > 40) {
			$weight = 15;
		} else if ($dif > 0) {
			$weight = 8;
		}

		if ($dif >= 0) {
			$expecScoreteam1 = ($weight * (1 - (1 / (1 + (10 ^ (($team1Elo - $team2Elo) / 400))))));
			$expecScoreteam2 = ($weight * (0 - (1 / (1 + (10 ^ (($team2Elo - $team1Elo) / 400))))));
			$team1New = $team1Elo - $expecScoreteam1;
			$team2New = $team2Elo + $expecScoreteam2;
		} else {
			$expecScoreteam1 = ($weight * (1 - (1 / (1 + (10 ^ (($team1Elo - $team2Elo) / 400))))));
			$expecScoreteam2 = ($weight * (0 - (1 / (1 + (10 ^ (($team2Elo - $team1Elo) / 400))))));
			$team1New = $team1Elo + $expecScoreteam1;
			$team2New = $team2Elo - $expecScoreteam2;
		}

		eloChange($team1, $team1New);
		eloChange($team2, $team2New);
	}
}



// Comments



function defenseComments($teamNumber)
{
	$teamData = getTeamData($teamNumber);
	$defenseComments = array();
	if ($teamData[8] != null) {
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
	if ($teamData[8] != null) {
		for ($i = 0; $i != sizeof($teamData[8]); $i++) {
			array_push($matchComments, $teamData[8][$i][22]);
		}
	}

	return ($matchComments);
}








function getPickList($teamNumber, $min = -1, $max = 1000)
{
	$teamData = getTeamData($teamNumber, $min, $max);
	$pointCal = 0;
	$matchCount = 0;
	if ($teamData[8] != null) {
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
	$tba = getTBAHandler();
	$data = $tba->makeDBCachedCall('/match/' . $match)['response'];

	return $data["score_breakdown"]["$alliance"]["$detail"];
}

function getMatchAlliance($match, $alliance, $team)
{
	// ************* Call API:
	$tba = getTBAHandler();
	$data = $tba->makeDBCachedCall('/match/' . $match)['response'];

	return substr($data["alliances"]["$alliance"]["team_keys"]["$team"], 3);
}

function getEventTeams()
{
	// ************* Call API:
	$match = getEventRaw();
	$tba = getTBAHandler();
	$data = $tba->makeDBCachedCall('/event/' . $match . '/teams/keys')['response'];
	$array = array();
	for ($i = 0; $i < count($data); $i++) {
		array_push($array, substr($data[$i], 3));
	}

	return $array;
}


function getOurMatches()
{
	$match = getEventRaw();
	$yourTeam = getYourTeam();
	$tba = getTBAHandler();
	$data = $tba->makeDBCachedCall('/team/' . $yourTeam . '/event/' . $match . '/matches/simple')['response'];
	$array = array();
	for ($i = 0; $i < count($data); $i++) {
		array_push($array, substr($data[$i]["key"], 9));
	}

	return $array;
}


function getOPR($teamNumber)
{
	// ************* Call API:
	$match = getEventRaw();
	$tba = getTBAHandler();
	$data = $tba->makeDBCachedCall('/event/' . $match . '/oprs')['response'];

	$teamNum = (string) $teamNumber;
	$teamNum = "frc" . $teamNumber;

	return ($data["oprs"][$teamNum]);
}
