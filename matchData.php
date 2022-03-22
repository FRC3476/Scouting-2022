<!DOCTYPE html>
<html>
<?php
include("header.php") ?>
<script src="js/bootstrap.min.js"></script>

<body onload="checkData()">
        <?php include("navBar.php") ?>
        <div id="content">
                <div class="container row-offcanvas row-offcanvas-left">
                        <div class="well column  col-lg-112  col-sm-12 col-xs-12" id="content">
                                <h1>Match Data</h1>
                                <div id="error"></div>
                                <script>
                                        function checkData() {
                                                // getting all the rows of data
                                                var data = document.getElementById("RawData");
                                                var rows = data.getElementsByTagName("tr");
                                                var largestMatch = -1;
                                                // i=1 because the first row is just the column labels
                                                for (var i = 1; i < rows.length; i++) {
                                                        var col = rows[i].getElementsByTagName("td");
                                                        largestMatch = col[2].innerHTML;
                                                }
                                                // create array to count match data entries
                                                var list = new Array();
                                                for (var i = 0; i < largestMatch; i++)
                                                        list.push(0); // starting value of zero for each match number
                                                // count how many data entries per match
                                                for (var i = 1; i < rows.length; i++) {
                                                        var col = rows[i].getElementsByTagName("td");
                                                        var num = col[2].innerHTML;
                                                        list[num - 1]++;
                                                }
                                                // list[0] is match 1
                                                //console.log(list);
                                                // check to see if data is missing
                                                // and add it to a warning message
                                                var warning = "";
                                                const matchTotal = 6; // how many entries there should be per match
                                                const style = "<p style='color:red;'>";
                                                for (var i = 0; i < rows.length; i++) {
                                                        var num = list[i];
                                                        if (num < matchTotal) {
                                                                var dif = matchTotal - num;
                                                                warning += style + "There are " + dif + " entries missing from match #" + (i + 1) + "</p>";
                                                        } else if (num > matchTotal) {
                                                                var dif = num - matchTotal;
                                                                warning += style + "There are " + dif + " extra entries for match #" + (i + 1) + "</p>";
                                                        }
                                                }
                                                if (warning != "")
                                                        document.getElementById("error").innerHTML = warning;
                                        }
                                </script>
                                <?php
                                include("databaseLibrary.php");
                                //end of new stuff
                                $result = getAllMatchData();
                                if ($result != null) {
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
                                                        if (!is_numeric($key) && ($row["matchNum"] == $_GET["match"])) {
                                                                if ($key == "matchNum") {
                                                                        $value = '<a href="matchData.php?match=' . $value . '">' . $value . '</a>';
                                                                        echo ("<td align='center'>" . $value . "</td>");
                                                                }
                                                        } else if ($key !=  "autoPath" && $key != "teleopPath") {
                                                                echo ("<td align='center'>" . $value . "</td>");
                                                        }
                                                }
                                        }
                                        echo ("</tr>");
                                }
                                echo ("</table>");
                                echo ("<script>checkData();</script>");
                                ?>
                        </div>
                </div>
        </div>
</body>

</html>
<?php include("footer.php") ?>