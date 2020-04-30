<?php

class Ranking{
    public $tournaments = [];
    public $ranking = [];

    function addTournament($tournament){
        $this->tournaments[] = $tournament;
    }


    function calculateRanking(){
        foreach($this->tournaments as $tournament){
            $participants = $tournament->getParticipants();
            
            foreach($participants as $participant){
                if($this->isParticipantInRanking($participant)){
                    $this->ranking[$participant] = array('name' => $participant, 'totalWins' => 0, 'totalSecond' => 0, 'totalThird' => 0, 'totalSitIn' => 0, 'totalMoney' => 0, 'totalProfit' => 0);
                }
                if($tournament->winner == $participant){
                    $this->ranking[$participant]['totalWins']++;
                    $this->ranking[$participant]['totalSitIn']++;
                }
                if($tournament->second == $participant){
                    $this->ranking[$participant]['totalSecond']++;
                    $this->ranking[$participant]['totalSitIn']++;
                }
                if($tournament->third == $participant){
                    $this->ranking[$participant]['totalThird']++;
                    $this->ranking[$participant]['totalSitIn']++;
                }        
            }
            
        }

    }


    function isParticipantinRanking($participant){
        return !array_key_exists($participant, $this->ranking);
    }


    function printRanking(){
        $this->calculateRanking();
        $this->calculateTotalMoney();



        $rows[] = "<tr>
        <th class='name'>Name</th>
        <th class='totalWins'>TotalWins</th>
        <th class='totalSecond'>TotalSecond</th>
        <th class='totalThird'>TotalSecond</th>
        <th class='totalSitIn'>Teilnahmen</th>
        <th class='totalMoney'>Preisgeld</th>
        <th class='totalProfit'>Profit</th>
    </tr>";
        foreach($this->ranking as $key => $row){
            $rows[] = "<tr>
                    <td>" . $key . "</td>
                    <td>" . $row['totalWins'] . "</td>
                    <td>" . $row['totalSecond'] . "</td>
                    <td>" . $row['totalThird'] . "</td>
                    <td>" . $row['totalSitIn'] . "</td>
                    <td>" . $row['totalMoney'] . "</td>
                    <td>" . $row['totalProfit'] . "</td>
                    </tr>";
        }

        echo "<table>" . implode('', $rows) . "</table>";
        
    }
    

    function calculateTotalMoney(){

        foreach($this->tournaments as $tournament){
            $participants = $tournament->getParticipants();
            $money = $tournament->getMoney();
            foreach($participants as $participant){
                if($this->isParticipantInRanking($participant)){
                    $this->ranking[$participant] = array('name' => $participant, 'totalMoney' => 0, 'totalProfit' => 0);
                    
                var_dump($participant);
                }
            }
            
        }

    }
}



            
?>