<?php
  require_once('databaseLibrary.php');
  require('databaseName.php');
  
  if (isset($_POST["writeAllianceRankData"])){
    leadScoutInput($_POST["matchKey"], $_POST["writeAllianceRankData"]);
    echo("success");
  }
  
  
?>