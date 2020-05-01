<?php

class Ranking
{
    public $tournaments = [];

    function loadTournaments()
    {
        $fileContents = file_get_contents('./tournaments.json');
        $rawTournaments = json_decode($fileContents);

        foreach ($rawTournaments as $t) {
            $this->tournaments[] = new Tournament($t);
        }
    }

    function calculateRanking(){

        $ranking = [];
        foreach($this->tournaments as $tournament){
            $participants = $tournament->getParticipants();
            
            foreach($participants as $participant){
                if(!array_key_exists($participant, $ranking)){
                    $ranking[$participant] = array('name' => $participant, 'totalWins' => 0, 'totalSecond' => 0, 'totalThird' => 0, 'totalSitIn' => 0, 'totalMoney' => 0, 'totalProfit' => 0);
                }
                
                $ranking[$participant]['totalProfit'] -= $tournament->buyIn;

                if($tournament->winner == $participant){
                    $ranking[$participant]['totalWins']++;
                    $ranking[$participant]['totalSitIn']++;
                    $ranking[$participant]['totalProfit'] += $tournament->moneyFirst;
                    $ranking[$participant]['totalMoney'] += $tournament->moneyFirst;
                }
                if($tournament->second == $participant){
                    $ranking[$participant]['totalSecond']++;
                    $ranking[$participant]['totalSitIn']++;
                    $ranking[$participant]['totalProfit'] += $tournament->moneySecond;
                    $ranking[$participant]['totalMoney'] += $tournament->moneySecond;
                }
                if($tournament->third == $participant){
                    $ranking[$participant]['totalThird']++;
                    $ranking[$participant]['totalSitIn']++;
                    $ranking[$participant]['totalProfit'] += $tournament->moneyThird;
                    $ranking[$participant]['totalMoney'] += $tournament->moneyThird;
                }        
            }
            
        }
        return $ranking;

    }

    function sort($ranking, $property = 'totalProfit'){
        usort($ranking, function ($a, $b) use ($property) {
            if ($a[$property] < $b[$property]) {
                return 1;
            }
            if ($a[$property] > $b[$property]) {
                return -1;
            }
            return 0;
            });

            return $ranking;
    
    }


    function isParticipantinRanking($participant){
        return !array_key_exists($participant, $this->ranking);
    }


    function printRanking()
    {
        $ranking = $this->calculateRanking();
        $ranking = $this->sort($ranking);

        $rows = ["<tr>
                <th>Name</th>
                <th>TotalWins</th>
                <th>TotalSecond</th>
                <th>TotalSecond</th>
                <th>Teilnahmen</th>
                <th>Preisgeld</th>
                <th>Profit</th>
            </tr>"];


        foreach ($ranking as $key => $row) {
            $rows[] = "<tr>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['totalWins'] . "</td>
                    <td>" . $row['totalSecond'] . "</td>
                    <td>" . $row['totalThird'] . "</td>
                    <td>" . $row['totalSitIn'] . "</td>
                    <td>" . $row['totalMoney'] . "</td>
                    <td>" . $row['totalProfit'] . "</td>
                    </tr>";
        }

        echo "<h3>Ranking:</h3><table>" . implode('', $rows) . "</table>";
    }
    
    function printTournaments()
    {
        $rows = ["<tr>
                    <th>date</th>
                    <th>winner</th>
                    <th>second</th>
                    <th>third</th>
                    <th>buyIn</th>
                    <th>moneyFirst</th>
                    <th>moneySecond</th>
                    <th>moneyThird</th>
           </tr>"];


        foreach ($this->tournaments as $tournament) {
            $rows[] = "<tr>
                <td class='date'>" . date('h:i d.m.y', $tournament->date) . "</td>
                <td>" . $tournament->winner . "</td>
                <td>" . $tournament->second . "</td>
                <td>" . $tournament->third . "</td>
                <td>" . $tournament->buyIn . "</td>
                <td>" . $tournament->moneyFirst . "</td>
                <td>" . $tournament->moneySecond . "</td>
                <td>" . $tournament->moneyThird . "</td>
            </tr>";
        }

        echo "<h3>Turniere:</h3><table>" . implode('', $rows) . "</table>";
    }

}



            
?>