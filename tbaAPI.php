<?php
  require('tbaHandler.php');
  require('databaseLibrary.php');
  require('databaseName.php');
  
  global $tbaTable;
  global $tbaKey;
  
  $tba = new tbaHandler($tbaKey, $tbaTable, connectToDB());
  
  if (isset($_GET["query"])){
    // Generic TBA query, passes value of query to TBA
    echo(json_encode($tba->makeDBCachedCall($_GET["query"])));
  }
  else if (isset($_GET["eventCode"])){
    $eventCode = $_GET["eventCode"];
    if (isset($_GET["getTeamList"])){
      echo(json_encode($tba->getSimpleTeamList($eventCode)));
    }
    else if (isset($_GET["getMatchList"])){
      echo(json_encode($tba->getMatches($eventCode)));
    }
    else if (isset($_GET["getCOPRs"])){
      echo(json_encode($tba->getComponentOPRS($eventCode)));
    }
    else {
      echo("API arguments not recognized.");
    }
  }
  else if (isset($_GET["createTable"])){
    createTBATable($tbaTable);
  }
  else {
    echo("Please use the 'eventCode' argument to specify event.");
  }
  
?>