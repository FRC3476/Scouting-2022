<?php
include("bet.php");

function filter($str)
{
	return filter_var($str, FILTER_SANITIZE_STRING);
}
?>

<?php
if (isset($_POST['matchNum'])) {

	include("databaseLibrary.php");
        $matchNum = filter($_POST['matchNum']);
        $RedScorePredict = filter($_POST['RedScorePredict']);
        $BlueScorePredict = filter($_POST['BlueScorePredict']);
        $TotalAutoRed = filter($_POST['TotalAutoRed']);
        $TotalAutoBlue = filter($_POST['TotalAutoBlue']);
        $Winner = filter($_POST['Winner']);
        $name = filter($_POST['name']);


	betInput(
		    $matchNum,
            $RedScorePredict,
            $BlueScorePredict,
            $TotalAutoRed,
            $TotalAutoBlue,
            $Winner,
            $name
	);
}


?>
