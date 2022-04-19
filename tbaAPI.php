<?php
  require_once('tbaHandler.php');
  require_once('databaseLibrary.php');
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
    else if (isset($_GET["lastEventOPRS"])){
      $teamList = $tba->getSimpleTeamList($eventCode);
      $oprs = $tba->getLastEventOPRS($teamList);
      // print_r($oprs);
      echo(json_encode($oprs));
    }
    else {
      echo("API arguments not recognized.");
    }
  }
  else if (isset($_GET["createTable"])){
    createTBATable($tbaTable);
  }
  
  
  function getTBAHandler(){
    global $tba;
    return $tba;
  }
  
  
  
?>