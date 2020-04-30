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
class Turnier {
    //Eigenschaften
      public $date;
      public $winner;
      public $second;
      public $third;
      public $buyIn;
      public $moneyFirst;
      public $moneySecond;
      public $moneyThird;
    //Methoden
    function set_date($date) {
        $this->date = $date;
      }
      function get_date() {
        return $this->date;
      }
      function set_winner($winner) {
        $this->winner = $winner;
      }
      function get_winner() {
        return $this->winner;
      }
      function set_second($second) {
        $this->second = $second;
      }
      function get_second() {
        return $this->second;
      }
      function set_third($third) {
        $this->third = $third;
      }
      function get_third() {
        return $this->third;
      }
      function set_buyIn($buyIn) {
        $this->buyIn = $buyIn;
      }
      function get_buyIn() {
        return $this->buyIn;
      }
      function set_moneyFirst($moneyFirst) {
        $this->moneyFirst = $moneyFirst;
      }
      function get_moneyFirst() {
        return $this->moneyFirst;
      }
      function set_moneySecond($moneySecond) {
        $this->moneySecond = $moneySecond;
      }
      function get_moneySecond() {
        return $this->moneySecond;
      }
      function set_moneyThird($moneyThird) {
        $this->moneyThird = $moneyThird;
      }
      function get_moneyThird() {
        return $this->moneyThird;
      }
    }
//

//tabelle anlegen
function html_table($data = array())
{
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



echo '<h1>Rohdaten $newTurnArray array</h1>';
//

echo '<pre>'.print_r($newTurnArray, true).'</pre>'; 

echo '<br>';

echo '<h2>Sieger:</h2>';
print_r($newTurn->get_winner());

//teilnehmer auflisten
$teilnehmer=array();

foreach($newTurn as $turnier){
  if (!in_array($newTurn->get_winner(), $teilnehmer)){
    $teilnehmer[]=$newTurn->get_winner();
  }
  if (!in_array($newTurn->get_second(), $teilnehmer)){
    $teilnehmer[]=$newTurn->get_second();
  }
  if (!in_array($newTurn->get_third(), $teilnehmer)){
    $teilnehmer[]=$newTurn->get_third();
  }

}



echo '<pre><h3>Teilnehmer</h3> <br> '.print_r($teilnehmer, true).'</pre>'; 



$ranking=array();

foreach($teilnehmer as $name){
    $ranking[$name] = array('name'=> $name, 'totalWins' => 0, 'totalSecond' => 0, 'totalThird' => 0, 'totalSitIn' => 0, 'totalMoney' => 0, 'totalProfit' => 0); 
    foreach($newTurnArray as $key => $value){
        if($value == $name){
            echo ' '.$key.' + '.$value.'';
            $ranking[$name]['totalWins']++;
            $ranking[$name]['totalSecond']++;
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