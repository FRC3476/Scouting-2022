<html>
<?php
include("header.php") ?>
<script src="js/bootstrap.min.js"></script>

<body>
  <?php include("navBar.php") ?>
  <div class="container row-offcanvas row-offcanvas-left">
    <div class="well column  col-lg-12  col-sm-12 col-xs-12" id="content">
      <h1>Predictions</h1>
      <div class="input-group mb-3">
        <input id="eventCode" type="text" class="form-control" placeholder="eventCode" aria-label="eventCode">
        <button id="loadEvent" type="button" class="btn btn-primary">Load Event</button>
        
        <div class="row">
          <div id="tableWrapper" class="">
            <table id="matchResults" class="table table-striped table-hover">
              <thead>
                <tr id="matchResultsTableKeys">
                  <tr>
                    <th colspan="1">Match</th>
                    <th colspan="3">Alliance</th>
                    <th colspan="1">Predicted OPR Score</th>
                    <th colspan="1">Predicted Data Score</th>
                    <th colspan="1">Real Score</th>
                  </tr>
                </tr>
              </thead>
              <tbody id="matchResultsTableData">
              </tbody>
            </table>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</body>

<style>
  table th, table tr{
    font-size: 12px;
  }
</style>

<script>
  
  $(document).ready(function() {
    
    var scoutingData = null;
    var lastEventOPRs = null;
    var matchInfo = null;
    var teamList = null;
    
    var procMatchData = [];
    
    function getSimpleMatchList(complexMatchList){
      var out = [];
      for(let mi in complexMatchList){
        var match = complexMatchList[mi];
        if (match["comp_level"] == "qm"){
          var currMatch = {};
          currMatch["match_number"] = match["match_number"];
          currMatch["red_teams"] = match["alliances"]["red"]["team_keys"];
          currMatch["blue_teams"] = match["alliances"]["blue"]["team_keys"];
          currMatch["red_score"] = match["score_breakdown"]["red"]["totalPoints"];
          currMatch["red_cargo_rp"] = match["score_breakdown"]["red"]["cargoBonusRankingPoint"];
          currMatch["red_endgame_rp"] = match["score_breakdown"]["red"]["hangarBonusRankingPoint"];
          currMatch["blue_score"] = match["score_breakdown"]["blue"]["totalPoints"];
          currMatch["blue_cargo_rp"] = match["score_breakdown"]["blue"]["cargoBonusRankingPoint"];
          currMatch["blue_endgame_rp"] = match["score_breakdown"]["blue"]["hangarBonusRankingPoint"];
        }
      }
      return out;
    }
    
    function predictMatches(simpleMatchlist, scoutingData, lastEventOPRS){
      var oprPrediction = {};
      var dataPrediction = {};
      
      for (let mi in simpleMatchList){
        var match = simpleMatchList[mi];
        
        oprPred = {'red_score' : 0, 'blue_score' : 0, 'red_cargo_rp': 0, 'blue_cargo_rp': 0, 'red_endgame_rp': 0, 'blue_endgame_rp': 0 };
        dataPred = {'red_score' : 0, 'blue_score' : 0, 'red_cargo_rp': 0, 'blue_cargo_rp': 0, 'red_endgame_rp': 0, 'blue_endgame_rp': 0 };
        
        for (let i in match["red_teams"]){
          var team = match["red_teams"][i];
          // OPR Pred
          oprPred['red_score'] += lastEventOPRS[team]['totalPoints'];
          oprPred['red_cargo_rp'] += lastEventOPRS[team]['matchCargoTotal'];
          oprPred['red_endgame_rp'] += lastEventOPRS[team]['endgamePoints'];
          // Data Pred
          dataPred['red_score'] += scoutingData[team]['totalPoints'];
          dataPred['red_cargo_rp'] += scoutingData[team]['ballsScored'];
          dataPred['red_endgame_rp'] += scoutingData[team]['endgamePoints'];
        }
        for (let i in match["blue_teams"]){
          var team = match["blue_teams"][i];
          // OPR Pred
          oprPred['blue_score'] += lastEventOPRS[team]['totalPoints'];
          oprPred['blue_cargo_rp'] += lastEventOPRS[team]['matchCargoTotal'];
          oprPred['blue_endgame_rp'] += lastEventOPRS[team]['endgamePoints'];
          // Data Pred
          dataPred['blue_score'] += scoutingData[team]['totalPoints'];
          dataPred['blue_cargo_rp'] += scoutingData[team]['ballsScored'];
          dataPred['blue_endgame_rp'] += scoutingData[team]['endgamePoints'];
        }
        
        oprPred["red_cargo_rp"]   = oprPred["red_cargo_rp"] >= 20;
        oprPred["blue_cargo_rp"]  = oprPred["blue_cargo_rp"] >= 20;
        dataPred["red_cargo_rp"]  = dataPred["red_cargo_rp"] >= 20;
        dataPred["blue_cargo_rp"] = dataPred["blue_cargo_rp"] >= 20;
        
        oprPred["red_endgame_rp"]    = oprPred["red_endgame_rp"] >= 16;
        oprPred["blue_endgame_rp"]   = oprPred["blue_endgame_rp"] >= 16;
        dataPred["red_endgame_rp"]   = dataPred["red_endgame_rp"] >= 16;
        dataPred["blue_endgame_rp"]  = dataPred["blue_endgame_rp"] >= 16;
        
        oprPrediction[match["match_number"]] = oprPred;
        dataPrediction[match["match_number"]] = dataPred;
      }
      
      var out = {}
      out["oprPrediction"] = oprPrediction;
      out["dataPrediction"] = dataPrediction;
      return out;
    }
    
    function displayMatchPredictions(ma
    
    function processPredictions(){
      if ((scoutingData != null) && (lastEventOPRs != null) && (matchInfo != null) && (teamList != null)){
        var simpleMatchList = getSimpleMatchList(matchInfo['response']);
        var matchPrediction = predictMatches(simpleMatchList, scoutingData, lastEventOPRS);
      }
    }
    
    $.get( "readAPI.php", {getAllAverageData : 1}).done( function( data ) {
      // Get Scouting Data
      scoutingData = JSON.parse(data)['response'];
      processPredictions();
    });
    
    $("#loadEvent").click(function(){
      $.get( "tbaAPI.php", {lastEventOPRS: 1, eventcode: $("#eventCode").val()}).done( function( data ) {
        // Get Last Event OPRs for team
        lastEventOPRs =  JSON.parse(data);
        processPredictions();
      });
      
      $.get( "tbaAPI.php", {getMatchList: 1, eventcode: $("#eventCode").val()}).done( function( data ) {
        // Get Matches
        matchInfo = JSON.parse(data);
        processPredictions();
      });
      
      $.get( "tbaAPI.php", {getTeamList: 1, eventcode: $("#eventCode").val()}).done( function( data ) {
        // Get Team List
        teamList = JSON.parse(data);
        processPredictions();
      });
      
      
    });
  }

</script>
<?php include("footer.php") ?>