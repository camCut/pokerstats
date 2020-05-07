<?php

require "./turnier.php";
require "./ranking.php";
$csv = array_map('str_getcsv', file('turnier.csv'));
$tournament = new Tournament();

$tournament->date = strtotime($csv[2][1]);
$tournament->winner = $csv[12][1];
$tournament->second = $csv[13][1];
$tournament->third = $csv[14][1];
$tournament->buyIn = $csv[6][1];
$tournament->moneyFirst = $csv[12][2];
$tournament->moneySecond = $csv[13][2];
$tournament->moneyThird = $csv[14][2];
$tournament->participants = [];

for($i = 12; $i<count($csv); $i++){
    if(is_int((int)$csv[$i][0]) && $csv[$i][0] != 0){
        array_push($tournament->participants, $csv[$i][1]);
        }
    }



echo '<pre>';
var_dump($tournament);

echo'</pre>';
$arr = $tournament->participants;
$json = json_encode($arr);
echo '<pre>';
var_dump($json, JSON_FORCE_OBJECT);
echo '</pre>';
?>