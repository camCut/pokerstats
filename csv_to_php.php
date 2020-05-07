<?php

require "./turnier.php";
require "./ranking.php";
$csv = array_map('str_getcsv', file('turnier.csv'));
//open or read json data
$data_results = file_get_contents('tournaments.json');
$tempArray = json_decode($data_results);

$tournaments = [];
for($i = 1; $i<count($csv[12]); $i+=8)
{
    //var_dump($csv[12][$i]);

    $tournament = new Tournament();

    $tournament->date = strtotime($csv[2][$i]);
    $tournament->winner = $csv[12][$i];
    $tournament->second = $csv[13][$i];
    $tournament->third = $csv[14][$i];
    $tournament->buyIn = (int)$csv[6][$i];
    $tournament->moneyFirst = (int)$csv[12][$i+1];
    $tournament->moneySecond = (int)$csv[13][$i+1];
    $tournament->moneyThird = (int)$csv[14][$i+1];
    $tournament->participants = [];

    for($s = 12; $s<count($csv); $s++){
     if(is_numeric($csv[$s][$i-1])){
         
        array_push($tournament->participants, $csv[$s][$i]);

        }
        
    }
//append additional json to json file
    $tempArray[] = $tournament;
    $tournaments[] = $tournament;

}




echo '<pre>';
var_dump($tempArray);
echo'</pre>';
$jsonData = json_encode($tempArray, JSON_PRETTY_PRINT);

file_put_contents('tournaments.json', $jsonData);   


?>