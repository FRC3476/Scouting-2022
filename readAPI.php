<?php
  require_once('databaseLibrary.php');
  require('databaseName.php');
  
  if (isset($_GET["getAllAverageData"])){
    echo(json_encode(getAllTeamAverageData()));
  }
  
?>