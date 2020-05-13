<?php

require "./turnier.php";
require "./ranking.php";
$csv = array_map('str_getcsv', file('turnier.csv'));


/* function sortbyDate($data, $property = 'date')
{
    usort($ranking, function ($a, $b) use ($property) {
        if ($a[$property] < $b[$property]) {
            return 1;
        }
        if ($a[$property] > $b[$property]) {
            return -1;
        }
        return 0;
    });

    return $data;

} */


//open or read json data
$data_results = file_get_contents('tournaments.json');
$tempArray = json_decode($data_results);

//$tempArraySorted = sortbyDate($tempArray);
$tournaments = [];

$dateTimeString = $csv[2][9] . "-" . $csv[3][9];
$dateTime = DateTime::createFromFormat('d.m.Y-H:i', $dateTimeString);


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

function cmp($a, $b) {
    return strcmp($a->date, $b->date);
}

$tournamentsSorted = usort($tempArray, "cmp");

echo '<pre>';
var_dump($tempArray);
echo '</pre>';


$jsonData = json_encode($tempArray, JSON_PRETTY_PRINT);

file_put_contents('tournaments.json', $jsonData);   


?>