<?php 

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

      function getParticipants(){
          return [
              $this->winner,
              $this->second,
              $this->third,
          ];
      }
      function getMoney(){
          return [
              $this->moneyFirst,
              $this->moneySecond,
              $this->moneyThird,
          ];
    }
    }

?>