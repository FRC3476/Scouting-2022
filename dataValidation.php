<!DOCTYPE html>

<html>
<?php
include("header.php") ?>
<script src="js/bootstrap.min.js"></script>

<body>
    <?php include("navBar.php") ?>
    <div id="content">
        <div class="container row-offcanvas row-offcanvas-left">
            <div class="well column  col-lg-112  col-sm-12 col-xs-12" id="content">
                <h1>Data Validation</h1>
                <form action="" method="get">
                    Enter Match Number:
                    <input type="text" name="match" id="match" size="8">
                    <button id="submit" class="btn btn-primary" onclick="">Display</button>
                    <br>
                    <br>
                    <?php
                    include("databaseLibrary.php");

                    $result = getAllMatchData();
                    if ($result != null) {
                        $totalAutoUpper = 0;
                        $totalTeleopUpper = 0;
                        $totalAutoLower = 0;
                        $totalTeleopLower = 0;
                        $climb = 0;

                        $totalredAutoUpper = 0;
                        $totalredTeleopUpper = 0;
                        $totalredAutoLower = 0;
                        $totalredTeleopLower = 0;
                        $climbred = 0;
                        $event = getEvent();
                        $match = $event . $_GET["match"];

                        echo ('<div><table  class="table table-hover" id="RawData" border="1"></div>');
                            foreach ($result as $row_key => $row) {
                                if ($i == 0) {
                                    echo ("<tr>");
                                    foreach ($row as $key => $value) {
                                        if (!is_numeric($key) && (($key != "autoPath") && ($key != "teleopPath"))) {
                                            echo ("<td>" . $key . "</td>");
                                        }
                                    }
                                    $i++;
                                    echo ("</tr>");
                                }
                            

                            echo ("<tr>");
                                foreach ($row as $key => $value) {
                                    if (!is_numeric($key) and $row["matchNum"] == $_GET["match"] and $row["allianceColor"] == "blue") {
                                        if ($key == "matchNum") {
                                            $value = '<a href="matchData.php?match=' . $value . '">' . $value . '</a>';
                                            echo ("<td align='center'>" . $value . "</td>");
                                        } else if ($key !=  "autoPath" && $key != "teleopPath") {
                                            if ($key == "upperGoal") {
                                                $abc = getCorrectData($match, "blue", "autoCargoUpperBlue") + getCorrectData($match, "blue", "autoCargoUpperFar") + getCorrectData($match, "blue", "autoCargoUpperNear") + getCorrectData($match, "blue", "autoCargoUpperRed");
                                                echo ("<td align='center'>" . $value . " - " . $abc . "</td>");
                                            } else if ($key == "upperGoalT") {
                                                $abc1 = getCorrectData($match, "blue", "teleopCargoUpperBlue") + getCorrectData($match, "blue", "teleopCargoUpperFar") + getCorrectData($match, "blue", "teleopCargoUpperNear") + getCorrectData($match, "blue", "teleopCargoUpperRed");
                                                echo ("<td align='center'>" . $value . " - " . $abc1 . "</td>");
                                            } else if ($key == "lowerGoal") {
                                                $abc2 = getCorrectData($match, "blue", "autoCargoLowerBlue") + getCorrectData($match, "blue", "autoCargoLowerFar") + getCorrectData($match, "blue", "autoCargoLowerNear") + getCorrectData($match, "blue", "autoCargoLowerRed");
                                                echo ("<td align='center'>" . $value . " - " . $abc2 . "</td>");
                                            } else if ($key == "lowerGoalT") {
                                                $abc3 = getCorrectData($match, "blue", "teleopCargoLowerBlue") + getCorrectData($match, "blue", "teleopCargoLowerFar") + getCorrectData($match, "blue", "teleopCargoLowerNear") + getCorrectData($match, "blue", "teleopCargoLowerRed");
                                                echo ("<td align='center'>" . $value . " - " . $abc3 . "</td>");
                                            }else if ($key == "climb") {
                                                echo ("<td align='center'>" . $value .  "</td>");
                                                $climb += $value*1;
                                            }else if ($key == "climbTwo") {
                                                echo ("<td align='center'>" . $value .  "</td>");
                                                $climb += $value*2;
                                            }else if ($key == "climbThree") {
                                                echo ("<td align='center'>" . $value .  "</td>");
                                                $climb += $value*3;
                                            }else if ($key == "climbFour") {
                                                echo ("<td align='center'>" . $value .  "</td>");
                                                $climb += $value*4;
                                            }else {
                                                echo ("<td align='center'>" . $value . "</td>");
                                            }
                                        }
                                        if (($key == "upperGoal")) {
                                            $totalAutoUpper += $value;
                                        }
                                        if (($key == "upperGoalT")) {
                                            $totalTeleopUpper += $value;
                                        }
                                        if (($key == "lowerGoal")) {
                                            $totalAutoLower += $value;
                                        }
                                        if (($key == "lowerGoalT")) {
                                            $totalTeleopLower += $value;
                                        }
                                    }
                                }

                            foreach ($row as $key => $value) {
                                if (!is_numeric($key) and $row["matchNum"] == $_GET["match"] and $row["allianceColor"] == "red") {
                                    if ($key == "matchNum") {
                                        $value = '<a href="matchData.php?match=' . $value . '">' . $value . '</a>';
                                        echo ("<td align='center'>" . $value . "</td>");
                                    } else if ($key !=  "autoPath" && $key != "teleopPath") {
                                        if ($key == "upperGoal") {
                                            $abc = getCorrectData($match, "red", "autoCargoUpperBlue") + getCorrectData($match, "red", "autoCargoUpperFar") + getCorrectData($match, "red", "autoCargoUpperNear") + getCorrectData($match, "red", "autoCargoUpperRed");
                                            echo ("<td align='center'>" . $value . " - " . $abc . "</td>");
                                        } else if ($key == "upperGoalT") {
                                            $abc1 = getCorrectData($match, "red", "teleopCargoUpperBlue") + getCorrectData($match, "red", "teleopCargoUpperFar") + getCorrectData($match, "red", "teleopCargoUpperNear") + getCorrectData($match, "red", "teleopCargoUpperRed");
                                            echo ("<td align='center'>" . $value . " - " . $abc1 . "</td>");
                                        } else if ($key == "lowerGoal") {
                                            $abc2 = getCorrectData($match, "red", "autoCargoLowerBlue") + getCorrectData($match, "red", "autoCargoLowerFar") + getCorrectData($match, "red", "autoCargoLowerNear") + getCorrectData($match, "red", "autoCargoLowerRed");
                                            echo ("<td align='center'>" . $value . " - " . $abc2 . "</td>");
                                        } else if ($key == "lowerGoalT") {
                                            $abc3 = getCorrectData($match, "red", "teleopCargoLowerBlue") + getCorrectData($match, "red", "teleopCargoLowerFar") + getCorrectData($match, "red", "teleopCargoLowerNear") + getCorrectData($match, "red", "teleopCargoLowerRed");
                                            echo ("<td align='center'>" . $value . " - " . $abc3 . "</td>");
                                        }else if ($key == "climb") {
                                            echo ("<td align='center'>" . $value .  "</td>");
                                            $climbred += $value*1;
                                        }else if ($key == "climbTwo") {
                                            echo ("<td align='center'>" . $value .  "</td>");
                                            $climbred += $value*2;
                                        }else if ($key == "climbThree") {
                                            echo ("<td align='center'>" . $value .  "</td>");
                                            $climbred += $value*3;
                                        }else if ($key == "climbFour") {
                                            echo ("<td align='center'>" . $value .  "</td>");
                                            $climbred += $value*4;
                                        }else {
                                            echo ("<td align='center'>" . $value . "</td>");
                                        }
                                    }
                                    if (($key == "upperGoal")) {
                                        $totalredAutoUpper += $value;
                                    }
                                    if (($key == "upperGoalT")) {
                                        $totalredTeleopUpper += $value;
                                    }
                                    if (($key == "lowerGoal")) {
                                        $totalredAutoLower += $value;
                                    }
                                    if (($key == "lowerGoalT")) {
                                        $totalredTeleopLower += $value;
                                    }
                                }
                            }
                            echo ("</tr>");
                            }
                        echo ("</table>");
                    }



                    $match = $event . $_GET["match"];

                    $blueClimbCheck = 0;
                    $redClimbCheck = 0;

                    if (getCorrectData($match, "blue", "endgameRobot1") == "Traversal") {
                        $blueClimbCheck += 4;
                    } else if (getCorrectData($match, "blue", "endgameRobot1") == "High") {
                        $blueClimbCheck += 3;
                    } else if (getCorrectData($match, "blue", "endgameRobot1") == "Mid") {
                        $blueClimbCheck += 2;
                    } else if (getCorrectData($match, "blue", "endgameRobot1") == "Low") {
                        $blueClimbCheck += 1;
                    }
                    if (getCorrectData($match, "blue", "endgameRobot2") == "Traversal") {
                        $blueClimbCheck += 4;
                    } else if (getCorrectData($match, "blue", "endgameRobot2") == "High") {
                        $blueClimbCheck += 3;
                    } else if (getCorrectData($match, "blue", "endgameRobot2") == "Mid") {
                        $blueClimbCheck += 2;
                    } else if (getCorrectData($match, "blue", "endgameRobot2") == "Low") {
                        $blueClimbCheck += 1;
                    }
                    if (getCorrectData($match, "blue", "endgameRobot3") == "Traversal") {
                        $blueClimbCheck += 4;
                    } else if (getCorrectData($match, "blue", "endgameRobot3") == "High") {
                        $blueClimbCheck += 3;
                    } else if (getCorrectData($match, "blue", "endgameRobot3") == "Mid") {
                        $blueClimbCheck += 2;
                    } else if (getCorrectData($match, "blue", "endgameRobot3") == "Low") {
                        $blueClimbCheck += 1;
                    }

                    if (getCorrectData($match, "red", "endgameRobot1") == "Traversal") {
                        $redClimbCheck += 4;
                    } else if (getCorrectData($match, "red", "endgameRobot1") == "High") {
                        $redClimbCheck += 3;
                    } else if (getCorrectData($match, "red", "endgameRobot1") == "Mid") {
                        $redClimbCheck += 2;
                    } else if (getCorrectData($match, "red", "endgameRobot1") == "Low") {
                        $redClimbCheck += 1;
                    }
                    if (getCorrectData($match, "red", "endgameRobot2") == "Traversal") {
                        $redClimbCheck += 4;
                    } else if (getCorrectData($match, "red", "endgameRobot2") == "High") {
                        $redClimbCheck += 3;
                    } else if (getCorrectData($match, "red", "endgameRobot2") == "Mid") {
                        $redClimbCheck += 2;
                    } else if (getCorrectData($match, "red", "endgameRobot2") == "Low") {
                        $redClimbCheck += 1;
                    }
                    if (getCorrectData($match, "red", "endgameRobot3") == "Traversal") {
                        $redClimbCheck += 4;
                    } else if (getCorrectData($match, "red", "endgameRobot3") == "High") {
                        $redClimbCheck += 3;
                    } else if (getCorrectData($match, "red", "endgameRobot3") == "Mid") {
                        $redClimbCheck += 2;
                    } else if (getCorrectData($match, "red", "endgameRobot3") == "Low") {
                        $redClimbCheck += 1;
                    }
                    if ($redClimbCheck != $climbred) {
                        echo "red climb incorrect ";
                    }
                    if ($blueClimbCheck != $climb) {
                        echo "blue climb incorrect ";
                    }




                    ?>
            </div>
        </div>
    </div>


</body>

</html>

<?php include("footer.php") ?>