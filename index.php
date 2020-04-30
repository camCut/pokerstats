<?php 

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
// neues Turnier anlegen
$tournament1 = new Turnier();
$tournament1->date =20200429;
$tournament1->winner ='Benni';
$tournament1->second ='Thom';
$tournament1->third ='Flo';
$tournament1->buyIn =10;
$tournament1->moneyFirst =22;
$tournament1->moneySecond =11;
$tournament1->moneyThird =5;

// neues Turnier anlegen
$tournament2 = new Turnier ();
$tournament2->date =20200430;
$tournament2->winner ='Frank';
$tournament2->second ='Flo';
$tournament2->third ='Benni';
$tournament2->buyIn =20;
$tournament2->moneyFirst =200;
$tournament2->moneySecond =110;
$tournament2->moneyThird =50;

// neues Turnier anlegen
$tournament3 = new Turnier ();
$tournament3->date =20200411;
$tournament3->winner ='Benni';
$tournament3->second ='Flo';
$tournament3->third ='Thom';
$tournament3->buyIn =40;
$tournament3->moneyFirst =100;
$tournament3->moneySecond =90;
$tournament3->moneyThird =30;


$ranking = new Ranking();
$ranking->addTournament($tournament1);
$ranking->addTournament($tournament2);
$ranking->addTournament($tournament3);

$ranking->printRanking();
var_dump($tournament1->getMoney());


/*
//Array in txt schreiben
$serializedData = serialize($totalTurn);

file_put_contents('turniere.txt', $serializedData);
//
*/



?>