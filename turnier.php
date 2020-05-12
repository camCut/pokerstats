<?php 

class Tournament 
{
    //Eigenschaften
      public $date;
      public $buyIn;
      public $participants;
      public $payOut;

      function getParticipants(){
          return [
              $this->participants,
          ];
        }
        function getPayOut(){
            return [
              $this->payOut,
            ];
          }
      

      
      function __construct($tournament = null)
      {
        if(!isset($tournament)){
           return;
        }
        
          $this->date = $tournament->date;
          $this->buyIn = $tournament->buyIn;
          $this->participants = $tournament->participants;
          $this->payOut = $tournament->payOut;
      }
}



?>