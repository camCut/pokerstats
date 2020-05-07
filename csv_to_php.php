<?php

require "./turnier.php";
require "./ranking.php";
$csv = array_map('str_getcsv', file('turnier.csv'));
$date = $csv[2][1];
$winner = $csv[12][1];
$second = $csv[13][1];
$third = $csv[14][1];
$buyIn = $csv[6][1];
$moneyFirst = $csv[12][2];
$moneySecond = $csv[13][2];
$moneyThird = $csv[14][2];
$participiants = [];

for($i = 12; $i<count($csv); $i++){
    array_push($participiants, $csv[$i][1]);
}


$newTourn = ["date" => $date, "winner" => $winner, "second" => $second, "third" => $third, "buyIn" => $buyIn, "moneyFirst" => $moneyFirst, "moneySecond" => $moneySecond, "moneyThird" => $moneyThird, "participiants" => $participiants];
$obj = (object) $newTourn;

$tournament = new Tournament($obj);

var_dump($tournament);

var_dump($csv);

?>