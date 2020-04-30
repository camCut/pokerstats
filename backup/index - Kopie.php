<?php 

/*
//array auslesen
// at a later point, you can convert it back to array like:
$recoveredData = file_get_contents('turniere.txt');

// unserializing to get actual array
$recoveredArray = unserialize($recoveredData);

// you can print your array like
//print_r($recoveredArray);

$totalTurn = $recoveredArray;
//
*/


//Turnier Klasse erstellen
require "./turnier.php";
require "./ranking.php";
//


//Preisgeld ermitteln
/*
function totalMoney($data = array()) {
    $totalMoney = 0;
    foreach ($data as $key => $value){
        $totalMoney += $value;
    }
  }
//


if($name == $data['winner']){
  $totalMoney += $data['moneyFirst'];
}
*/
//tabelle anlegen
function html_table($data = array()) {
    $rows = array();
    foreach ($data as $key => $row) { //nachlesen
        $cells = array();
        $rows[] = "<tr><td>".$key."</td><td>".$row['totalWins']."</td><td>".$row['totalSecond']."</td><td>".$row['totalThird']."</td><td>".$row['totalSitIn']."</td><td>".$row['totalMoney']."</td><td>".$row['totalProfit']."</td></tr>";
    }
    return "<table>
            <tr>
                <td class='name'>Name</td>
                <td class='totalWins'>TotalWins</td>
                <td class='totalSecond'>TotalSecond</td>
                <td class='totalThird'>TotalSecond</td>
                <td class='totalSitIn'>Teilnahmen</td>
                <td class='totalMoney'>Preisgeld</td>
                <td class='totalProfit'>Profit</td>
            </tr>" . implode('', $rows) . "</table>";
}
//

// neues Turnier anlegen
$newTurn = new Turnier();
$newTurn->set_date(20200429);
$newTurn->set_winner('Benni');
$newTurn->set_second('Thom');
$newTurn->set_third('Flo');
//$newTurn->forth = "Peter";
$newTurn->set_buyIn(10);
$newTurn->set_moneyFirst(22);
$newTurn->set_moneySecond(11);
$newTurn->set_moneyThird(5);

// neues Turnier anlegen
$newTurn2 = new Turnier();
$newTurn2->set_date(20200430);
$newTurn2->set_winner('Frank');
$newTurn2->set_second('Flo');
$newTurn2->set_third('Benni');
//$newTurn2->forth = "Peter";
$newTurn2->set_buyIn(20);
$newTurn2->set_moneyFirst(200);
$newTurn2->set_moneySecond(110);
$newTurn2->set_moneyThird(50);


echo '<div><h1>Rohdaten $newTurn</h1></div>';
/*
echo 'Datum: '.$newTurn->get_date().'<br>';
echo 'Sieger: '.$newTurn->get_winner().'<br>';
echo 'Zweiter: '.$newTurn->get_second().'<br>';
echo 'Dritter: '.$newTurn->get_third().'<br>';
echo 'BuyIn: '.$newTurn->get_buyIn().'<br>';
echo 'Preisgeld 1.: '.$newTurn->get_moneyFirst().'<br>';
echo 'Preisgeld 2.: '.$newTurn->get_moneySecond().'<br>';
echo 'Preisgeld 3.: '.$newTurn->get_moneyThird().'<br>';
*/


echo '<div><pre>'.print_r($newTurn, true).'</pre></div>'; 



$newTurnArray = (array) $newTurn;

$newTurnArray2 = (array) $newTurn2;

$totalTurn = array($newTurnArray, $newTurnArray2);



echo '<h1>$totalTurn</h1>';
//

echo '<pre>'.print_r($totalTurn, true).'</pre>'; 

echo '<br>';

echo '<h2>Sieger:</h2>';

//teilnehmer auflisten
$teilnehmer=array();

foreach($totalTurn as $turnier){
  if (!in_array($turnier['winner'], $teilnehmer)){
    $teilnehmer[]=$turnier['winner'];
  }
  if (!in_array($turnier['second'], $teilnehmer)){
    $teilnehmer[]=$turnier['second'];
  }
  if (!in_array($turnier['winner'], $teilnehmer)){
    $teilnehmer[]=$turnier['winner'];
  }

}

echo '<pre><h3>Teilnehmer</h3> <br> '.print_r($teilnehmer, true).'</pre>'; 


$ranking=array();

foreach($teilnehmer as $name){
    $ranking[$name] = array('name'=> $name, 'totalWins' => 0, 'totalSecond' => 0, 'totalThird' => 0, 'totalSitIn' => 0, 'totalMoney' => 0, 'totalProfit' => 0); 
    foreach($totalTurn as $turnier){
        if($turnier['winner'] == $name){
            $ranking[$name]['totalWins']++;
            $ranking[$name]['totalSitIn']++;
        }
        if($turnier['second'] == $name){
            $ranking[$name]['totalSecond']++;
            $ranking[$name]['totalSitIn']++;
        }
        if($turnier['third'] == $name){
            $ranking[$name]['totalThird']++;
            $ranking[$name]['totalSitIn']++;
        }        
    }
    
}


echo '<pre><h3>Ranking:</h3> '.print_r($ranking, true).'</pre>'; 


echo html_table($ranking);

echo '<br>';

/*
//Array in txt schreiben
$serializedData = serialize($totalTurn);

file_put_contents('turniere.txt', $serializedData);
//
*/



?>