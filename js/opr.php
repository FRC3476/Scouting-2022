<?php

$teamList = array();
$noOfGames = 0;
$realScore = array();

$event = "2021catt";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.thebluealliance.com/api/v3/event/" . $event  . "/matches?X-TBA-Auth-Key=VPexr6soymZP0UMtFw2qZ11pLWcaDSxCMUYOfMuRj5CQT3bzoExsUGHuO1JvyCyU");
curl_setopt($ch, CURLOPT_HEADER, 0);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
$json = curl_exec($ch);
curl_close ($ch);
$data = json_decode($json,true);
$length = count($data);

$filename = "oprRev.txt";
$f = fopen($filename, "w");
for ($i=0; $i<$length; $i++){
    fputs($f, $data[$i]["alliances"]["red"]["team_keys"][0] .", ". $data[$i]["alliances"]["red"]["team_keys"][1] .", ". $data[$i]["alliances"]["red"]["team_keys"][2] .", ". $data[$i]["alliances"]["red"]["score"] .", ". $data[$i]["alliances"]["red"]["team_keys"][0] .", ". $data[$i]["alliances"]["red"]["team_keys"][1] .", ". $data[$i]["alliances"]["red"]["team_keys"][2] .", ". $data[$i]["alliances"]["red"]["score"]);
}
fclose($f);


$csvFile = file('oprRev.txt');
$csvData = file_get_contents($csvFile);
$lines = explode(PHP_EOL, $csvData);
$array = array();
foreach ($lines as $line) {
    $array[] = str_getcsv($line);
}
print_r($array);

for ($i = 0; $i < count($array); $i++){
    if ($array[$i] == 0){
        break;
    }

    if ((trim($array[$i][3]) == "NULL") or (trim($array[$i][7]) == "NULL")){
        continue;
    }

    if ((is_array(trim($array[$i][0]))) and (trim($array[$i][0]) != "NULL")){ 
        array_push($teamList, trim($array[$i][0]));
    }

    if ((is_array(trim($array[$i][1]))) and (trim($array[$i][1]) != "NULL")){ 
        array_push($teamList, trim($array[$i][1]));
    }

    if ((is_array(trim($array[$i][2]))) and (trim($array[$i][2]) != "NULL")){ 
        array_push($teamList, trim($array[$i][2]));
    }

    if ((is_array(trim($array[$i][4]))) and (trim($array[$i][4]) != "NULL")){ 
        array_push($teamList, trim($array[$i][4]));
    }

    if ((is_array(trim($array[$i][5]))) and (trim($array[$i][5]) != "NULL")){ 
        array_push($teamList, trim($array[$i][5]));
    }

    if ((is_array(trim($array[$i][6]))) and (trim($array[$i][6]) != "NULL")){ 
        array_push($teamList, trim($array[$i][6]));
    }

    $noOfGames += 1;

}



?>