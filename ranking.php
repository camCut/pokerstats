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
                    $ranking[$participant] = array('name' => $participant, 'totalWins' => 0, 'totalSecond' => 0, 'totalThird' => 0, 'totalSitIn' => 0, 'totalMoney' => 0, 'totalProfit' => 0, 'headsUp' => 0);
                }
                
                $ranking[$participant]['totalProfit'] -= $tournament->buyIn;

                if($tournament->winner == $participant){
                    $ranking[$participant]['totalWins']++;
                    $ranking[$participant]['totalSitIn']++;
                    $ranking[$participant]['totalProfit'] += $tournament->moneyFirst;
                    $ranking[$participant]['totalMoney'] += $tournament->moneyFirst;
                    $ranking[$participant]['headsUp'] += 1;
                }
                if($tournament->second == $participant){
                    $ranking[$participant]['totalSecond']++;
                    $ranking[$participant]['totalSitIn']++;
                    $ranking[$participant]['totalProfit'] += $tournament->moneySecond;
                    $ranking[$participant]['totalMoney'] += $tournament->moneySecond;
                    $ranking[$participant]['headsUp'] += 1;
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

    function sortProfit($ranking, $property = 'totalProfit'){
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


    function printRankingProfit()
    {
        $ranking = $this->calculateRanking();
        $ranking = $this->sortProfit($ranking);

        $rows = ["<tr>
                <th>Name</th>
                <th>TotalWins</th>
                <th>TotalSecond</th>
                <th>TotalSecond</th>
                <th>Teilnahmen</th>
                <th>Preisgeld</th>
                <th>Profit</th>
                <th>HeadsUp</th>
                <th>HeadsUp Quote</th>
            </tr>"];


        foreach ($ranking as $key => $row) {
            if($key == 0){
                $rows[] = "<tr>
                    <td class=first>" . $row['name'] . "</td>
                    <td class=first>" . $row['totalWins'] . "</td>
                    <td class=first>" . $row['totalSecond'] . "</td>
                    <td class=first>" . $row['totalThird'] . "</td>
                    <td class=first>" . $row['totalSitIn'] . "</td>
                    <td class=first>" . $row['totalMoney'] . "€</td>
                    <td class=first>" . $row['totalProfit'] . "€</td>
                    <td class=first>" . $row['headsUp'] . "</td>
                    <td class=first>" . $row['headsUp'] / $row['totalSitIn'] * 100 . "%</td>
                    </tr>";
            }
            if($key == 1){
                $rows[] = "<tr>
                    <td class=second>" . $row['name'] . "</td>
                    <td class=second>" . $row['totalWins'] . "</td>
                    <td class=second>" . $row['totalSecond'] . "</td>
                    <td class=second>" . $row['totalThird'] . "</td>
                    <td class=second>" . $row['totalSitIn'] . "</td>
                    <td class=second>" . $row['totalMoney'] . "€</td>
                    <td class=second>" . $row['totalProfit'] . "€</td>
                    <td class=second>" . $row['headsUp'] . "</td>
                    <td class=second>" . $row['headsUp'] / $row['totalSitIn'] * 100 . "%</td>
                    </tr>";
            }
            if($key == 2){
                $rows[] = "<tr>
                    <td class=third>" . $row['name'] . "</td>
                    <td class=third>" . $row['totalWins'] . "</td>
                    <td class=third>" . $row['totalSecond'] . "</td>
                    <td class=third>" . $row['totalThird'] . "</td>
                    <td class=third>" . $row['totalSitIn'] . "</td>
                    <td class=third>" . $row['totalMoney'] . "€</td>
                    <td class=third>" . $row['totalProfit'] . "€</td>
                    <td class=third>" . $row['headsUp'] . "</td>
                    <td class=third>" . $row['headsUp'] / $row['totalSitIn'] * 100 . "%</td>
                    </tr>";
            }
            if($key > 2){
                $rows[] = "<tr>
                    <td class=rest>" . $row['name'] . "</td>
                    <td class=rest>" . $row['totalWins'] . "</td>
                    <td class=rest>" . $row['totalSecond'] . "</td>
                    <td class=rest>" . $row['totalThird'] . "</td>
                    <td class=rest>" . $row['totalSitIn'] . "</td>
                    <td class=rest>" . $row['totalMoney'] . "€</td>
                    <td class=rest>" . $row['totalProfit'] . "€</td>
                    <td class=rest>" . $row['headsUp'] . "</td>
                    <td class=rest>" . intval($row['headsUp'] / $row['totalSitIn'] * 100) . "%</td>
                    </tr>";
            }
        }

        echo "<table><th>Profit nach ".count($this->tournaments)." Turnieren</th>" . implode('', $rows) . "</table>";
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
                <td>" . date('h:i d.m.y', $tournament->date) . "</td>
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