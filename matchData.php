<!DOCTYPE html>

<html>
<?php
include("header.php")?>
<body>
<?php include("navBar.php")?>
<div id="content">
<div class="container row-offcanvas row-offcanvas-left">
<div class="well column  col-lg-112  col-sm-12 col-xs-12" id="content">
<h1>Match Data</h1>
	<form action="" method="get">
	Enter Match Number: 
	<input type="text" name="match" id="match" size="8">
	<button id="submit" class="btn btn-primary" onclick="">Display</button>
	<br>
	<br>
<?php
	include("databaseLibrary.php");
	$result = getAllLeadScoutData();
	$w=0;
       if ($result != null){
        echo('<div style="overflow-y:hidden;"><table  class="sortable table table-hover" id="RawData" border="1">');
        foreach ($result as $row_key => $row){
                if($w==0){
                        echo("<tr>");
                        foreach ($row as $key => $value){
                                        if(!is_numeric($key)){
                                        echo("<td>".$key."</td>");
                                }
                        }
                        $w++;
                        echo("</tr>");                
                }
                                                echo("<tr>");        
                        foreach ($row as $key => $value){
                                if(!is_numeric($key) and $row["matchNum"] == $_GET["match"]){
                                        if($key == "matchNum"){
                                                $value= '<a href="leadScoutForm.php?match='.$value.'">'.$value.'</a>';
                                                                                        
                                        }
                                                                                echo("<td align='center'>".$value."</td>");
                                                                                
                        }
                }        
                echo("</tr>");                    
                }
                echo("</table>");
        }

	 //end of new stuff
        
       $result = getAllMatchData();
       if ($result != null){

        echo('<div><table  class="table table-hover" id="RawData" border="1"></div>');
        foreach ($result as $row_key => $row){
                if($i==0){
                        echo("<tr>");
                        foreach ($row as $key => $value){
                                        if(!is_numeric($key) && $key != "autoPath"){
                                        echo("<td>".$key."</td>");
                                                                                }
                                }
                        $i++;
                        echo("</tr>");                
                }
                echo("<tr>");        
                        foreach ($row as $key => $value) {
                                if(!is_numeric($key) and $row["matchNum"] == $_GET["match"]){
                                        if($key == "matchNum"){
                                                $value= '<a href="matchData.php?match='.$value.'">'.$value.'</a>';
                                                                                        echo("<td align='center'>".$value."</td>");
                                        }
                                                                                else if($key != "autoPath"){
                                                                                        echo("<td align='center'>".$value."</td>");
                                                                                }
                                                                                
                                                                                
                        }
                }        
                echo("</tr>");                
                }
                echo("</table>");
        }
/*
            $result = getAllPrimaryMatchData();
            echo('<div><table  class="table table-hover" id="RawData" border="1"></div>');
            foreach ($result as $row_key => $row){
                    if($i==0){
                            echo("<tr>");
                            foreach ($row as $key => $value){
                                         if(!is_numeric($key) && $key != "cycleNumber"){
                                            echo("<td>".$key."</td>");
                                                                             }
                                    }
                            $i++;
                            echo("</tr>");  
                    }
        
                    echo("<tr>");        
                         foreach ($row as $key => $value) {
                                 if(!is_numeric($key) and $row["matchNum"] == $_GET["match"]){
                                         if($key == "matchNum"){
                                              $value= '<a href="matchData.php?match='.$value.'">'.$value.'</a>';
                                                                                     echo("<td align='center'>".$value."</td>");
                                         }
                                                                             else if($key != "cycleNumber"){
                                                                                     echo("<td align='center'>".$value."</td>");
                                                                             }
                                                                             
                                                                             
                            }
                    }        
                    echo("</tr>");                
                 }
                 echo("</table>");
                
                $result = getAllSecondaryMatchData();
       
            echo('<div><table  class="table table-hover" id="RawData" border="1"></div>');
            foreach ($result as $row_key => $row){
                    if($i==0){
                            echo("<tr>");
                            foreach ($row as $key => $value){
                                         if(!is_numeric($key) && (($key != "autoPath") && ($key != "teleopPath"))){
                                            echo("<td>".$key."</td>");
                                                                             }
                                    }
                            $i++;
                            echo("</tr>");                
                    }
                    echo("<tr>");        
                         foreach ($row as $key => $value) {
                                 if(!is_numeric($key) and $row["matchNum"] == $_GET["match"]){
                                         if($key == "matchNum"){
                                              $value= '<a href="matchData.php?match='.$value.'">'.$value.'</a>';
                                                                                     echo("<td align='center'>".$value."</td>");
                                         }
                                                                             else if(($key != "autoPath") && ($key != "teleopPath")){
                                                                                     echo("<td align='center'>".$value."</td>");
                                                                             }
                                                                             
                                                                             
                            }
                    }        
                    echo("</tr>");                
                 }
                 echo("</table>");
*/
                 $result = getAllNewMatchData();
       
            echo('<div><table  class="table table-hover" id="RawData" border="1"></div>');
            foreach ($result as $row_key => $row){
                    if($i==0){
                            echo("<tr>");
                            foreach ($row as $key => $value){
                                         if((!is_numeric($key) && $key != "cycleNumber") && (($key != "autoPath") && ($key != "teleopPath"))){
                                            echo("<td>".$key."</td>");
                                                                             }
                                    }
                            $i++;
                            echo("</tr>");                
                    }
                    echo("<tr>");        
                         foreach ($row as $key => $value) {
                                 if(!is_numeric($key) and $row["matchNum"] == $_GET["match"]){
                                         if($key == "matchNum"){
                                              $value= '<a href="matchData.php?match='.$value.'">'.$value.'</a>';
                                                                                     echo("<td align='center'>".$value."</td>");
                                         }
                                                                             else if($key != "cycleNumber" && ($key != "autoPath") && ($key != "teleopPath")){
                                                                                     echo("<td align='center'>".$value."</td>");
                                                                             }
                                                                             
                                                                             
                            }
                    }        
                    echo("</tr>");                
                 }
                 echo("</table>");

        
                 
?>
</div>
</div>
</div>


</body>
</html>

<?php include("footer.php") ?>