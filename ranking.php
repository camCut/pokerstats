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

    function calculateRanking()
    {
        $ranking = [];
        foreach ($this->tournaments as $tournament) {
            $participants = $tournament->participants;

            foreach ($participants as $participant) {
                if (!array_key_exists($participant, $ranking)) {
                    $ranking[$participant] = array('name' => $participant, 'totalWins' => 0, 'totalSecond' => 0, 'totalThird' => 0, 'totalSitIn' => 0, 'totalMoney' => 0, 'totalProfit' => 0, 'headsUp' => 0);
                }
                $ranking[$participant]['totalProfit'] -= $tournament->buyIn;

                    
                $i = 0;

                    if ($tournament->participants[$i] == $participant  && $tournament->payOut[$i] != "" ) {
                        //$ranking[$participant]['headsUp']++;             
                            $ranking[$participant]['totalMoney'] += intval($tournament->payOut[$i]);
                            $ranking[$participant]['totalProfit'] += intval($tournament->payOut[$i]);
                            $ranking[$participant]['totalSitIn'] ++;
                    }

                    if($tournament->participants[0] == $participant ){
                            $ranking[$participant]['totalWins'] ++;
                            $ranking[$participant]['headsUp'] ++;
                            $ranking[$participant]['totalSitIn'] ++;
                    }

                    if($tournament->participants[1] == $participant ){
                            $ranking[$participant]['totalSecond'] ++;
                            $ranking[$participant]['headsUp'] ++;
                            $ranking[$participant]['totalSitIn'] ++;
                    }

                    if($tournament->participants[2] == $participant ){
                            $ranking[$participant]['totalThird'] ++;
                            $ranking[$participant]['totalSitIn'] ++;
                    }

                    if ($tournament->participants[$i] == $participant) {
                            $ranking[$participant]['totalSitIn'] ++;
                            $i++;                            
                    }
            }

            //echo '<pre>';
            //var_dump($ranking);
            //echo '</pre>';
        }
        return $ranking;

    }

    function sortProfit($ranking, $property = 'totalProfit')
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

        return $ranking;

    }


    function isParticipantinRanking($participant)
    {
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
                <th>TotalThird</th>
                <th>Teilnahmen</th>
                <th>Preisgeld</th>
                <th>Profit</th>
                <th>HeadsUp</th>
                <th>HeadsUp Quote</th>
            </tr>"];


        foreach ($ranking as $key => $row) {
            $rowClass = $this->getRowClass($key);

            $rows[] = "<tr class='" . $rowClass . "'>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['totalWins'] . "</td>
                    <td>" . $row['totalSecond'] . "</td>
                    <td>" . $row['totalThird'] . "</td>
                    <td>" . $row['totalSitIn'] . "</td>
                    <td>" . $row['totalMoney'] . "&euro;</td>
                    <td>" . $row['totalProfit'] . "&euro;</td>
                    <td>" . $row['headsUp'] . "</td>
                    <td>" .intval($row['headsUp'] / $row['totalSitIn'] * 100) . "%</td>
                    </tr>";
        }

        echo "<table><th>Profit nach " . count($this->tournaments) . " Turnieren</th>" . implode('', $rows) . "</table>";
    }

    function getRowClass($key)
    {
        switch ($key) {
            case 0:
                return 'first';
            case 1:
                return 'second';
            case 2:
                return 'third';
            default:
                return 'rest';
        }
    }

    function getRankingData()
    {
        $ranking = $this->calculateRanking();
        return json_encode($ranking);
    }

    function getTournamentData()
    {
        return file_get_contents('./tournaments.json');
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

        echo "<h3>Turniere:</h3><table class='table'>" . implode('', $rows) . "</table>";
    }

}


?>
