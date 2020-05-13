<?php

require "./turnier.php";
require "./ranking.php";
$csv = array_map('str_getcsv', file('turnier.csv'));


//open or read json data
$data_results = file_get_contents('tournaments.json');
$tempArray = json_decode($data_results);

$tournaments = [];
echo $csv[2][1] . "-" . $csv[3][1];
for($i = 1; $i<count($csv[12]); $i+=8)
{
    //var_dump($csv[12][$i]);

    $tournament = new Tournament();
    $dateTimeString = $csv[2][$i] . "-" . $csv[3][$i];
    $dateTime = DateTime::createFromFormat('d.m.Y-H:i', $dateTimeString);

    $tournament->date = $dateTime ? $dateTime->getTimestamp() : 0;
    $tournament->buyIn = (int)$csv[6][$i];
    //add participants
    $tournament->participants = [];
    for($s = 12; $s<count($csv); $s++){
     if($csv[$s][$i+1] != "")
        {
        array_push($tournament->participants, $csv[$s][$i]);
        }
    }
    //add payOut
    $tournament->payOut = [];
    for($s = 12; $s<count($csv); $s++){
     if($csv[$s][$i+4] != "")
     {
       
        array_push($tournament->payOut, floatval($csv[$s][$i+1]));
    }

        
        
    }
    //var_dump($tournament->payOut);
//append additional json to json file
    $tempArray[] = $tournament;
    $tournaments[] = $tournament;

}




echo '<pre>';
var_dump($tournaments);
echo'</pre>';
$jsonData = json_encode($tempArray, JSON_PRETTY_PRINT);

file_put_contents('tournaments.json', $jsonData);   


?>