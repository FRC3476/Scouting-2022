<html>
<?php include("navBar.php");

function filter($str)
{
    return filter_var($str, FILTER_SANITIZE_STRING);
}
if (isset($_POST['matchNum'])) {
    if ($_POST['matchNum'] != "") {


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
}
?>
<script>
	function postwith(to) {

		var nums = {
			'matchNum': document.getElementById('matchNum').value,
			'RedScorePredict': document.getElementById('RedScorePredict').value,
			'BlueScorePredict': document.getElementById('BlueScorePredict').value,
			'TotalAutoRed': document.getElementById('TotalAutoRed').value,
			'TotalAutoBlue': document.getElementById('TotalAutoBlue').value,
			'Winner': document.getElementById('Winner').value,
			'name': document.getElementById('name').value
		};

		console.log(JSON.stringify(nums));
		$.post("betHandler.php", nums).done(function(data) {}).done(function() {
			alert("Submission Succeeded! Form Reloading.");
			location.reload(true);
		}).fail(function() {
			alert("Submission Failed! Please alert your head or lead scout!");
		});
	}
</script>

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
            <a>
                <h2><b><u>Bet Page:</u></b></h2>
            </a>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <b><text class="col-lg-2 control-label">Name: </text></b>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder=" ">
                    </div>
                </div>

                <div class="col-lg-2">
                    <b><br>Match Number: </b>
                </div>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="matchNum" name="matchNum" placeholder=" ">
                </div>

                <div class="col-lg-2">
                    <b><br>Will Red Alliance Score More or Less than: </b>
                </div>
                <div class="col-lg-10">
                    <select id="RedScorePredict" class="form-control">
                        <option value='More'>More</option>
                        <option value='Less'>Less</option>
                        <option value='Equal'>Equal</option>
                    </select>
                </div>

                <div class="col-lg-2">
                    <b><br>Will Blue Alliance Score More, Less, or Equal to: </b>
                </div>
                <div class="col-lg-10">
                    <select id="BlueScorePredict" class="form-control">
                        <option value='More'>More</option>
                        <option value='Less'>Less</option>
                        <option value='Equal'>Equal</option>
                    </select>
                    <br>
                    <br>
                </div>

                <div class="col-lg-2">
                    <b><br>Auto Balls Scored by Red Alliance: </b>
                </div>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="TotalAutoRed" name="TotalAutoRed" placeholder=" ">
                    <br>
                </div>

                <div class="col-lg-2">
                    <b><br>Auto Balls Scored by Blue Alliance: </b>
                </div>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="TotalAutoBlue" name="TotalAutoBlue" placeholder=" ">
                    <br>
                </div>

                <div class="col-lg-2">
                    <b><br>Which Alliance will Win: </b>
                </div>
                <div class="col-lg-10">
                    <select id="Winner" class="form-control">
                        <option value='Blue'>Blue</option>
                        <option value='Red'>Red</option>
                    </select>
                    <br>
                </div>

                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <input id="Bet" type="submit" class="btn btn-primary" value="Submit Data" onclick="postwith('')">
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
            bottom: 10px;
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
            margin-left: 100%;

        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
            border-radius: 5px;
        }

        .container:hover input~.checkmark {
            background-color: orange;
        }

        .container2 input:checked~.checkmark {
            background-color: rgb(15, 129, 120);
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .container2 input:checked~.checkmark:after {
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