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

            $i = 0;
            foreach ($participants as $participant) {
                if (!array_key_exists($participant, $ranking)) {
                    $ranking[$participant] = array('name' => $participant, 'totalWins' => 0, 'totalSecond' => 0, 'totalThird' => 0, 'totalSitIn' => 0, 'totalMoney' => 0, 'totalProfit' => 0, 'headsUp' => 0);
                }
                $ranking[$participant]['totalProfit'] -= $tournament->buyIn;
                $ranking[$participant]['totalSitIn']++;
                
                if($i < sizeof($tournament->payOut)){
                    $ranking[$participant]['totalMoney'] += $tournament->payOut[$i];
                    $ranking[$participant]['totalProfit'] += $tournament->payOut[$i];
                }

                switch ($i){                                            
                    case (0):
                            $ranking[$participant]['totalWins'] ++;
                            $ranking[$participant]['headsUp'] ++;
                            break;

                    case (1):
                        $ranking[$participant]['totalSecond'] ++;
                        $ranking[$participant]['headsUp'] ++;
                        break;

                    case (2):
                        $ranking[$participant]['totalThird'] ++;
                        break; 
                    
            }
            $i++;


            }
        
      /*   echo '<pre>';
        var_dump($ranking);
        echo '</pre>'; */

        }
        
        return $ranking;
    }

    function sortRanking($ranking, $property = 'totalProfit')
    {
        if($property != 'name'){
            usort($ranking, function ($a, $b) use ($property) {
                if (strtolower($a[$property]) < strtolower($b[$property])) {
                    return 1;
                }
                if (strtolower($a[$property]) > strtolower($b[$property])) {
                    return -1;
                }
                return 0;
            });

            return $ranking;
        }
        else{
            usort($ranking, function ($a, $b) use ($property) {
                if (strtolower($a[$property]) < strtolower($b[$property])) {
                    return -1;
                }
                if (strtolower($a[$property]) > strtolower($b[$property])) {
                    return 1;
                }
                return 0;
            });

            return $ranking;
        }

    }



    function isParticipantinRanking($participant)
    {
        return !array_key_exists($participant, $this->ranking);
    }


    function printRanking()
    {
        
        $ranking = $this->calculateRanking();
        if(!isset($_GET['sortBy']) ){
            $ranking = $this->sortRanking($ranking);
        }
        else{
            $ranking = $this->sortRanking($ranking, $_GET['sortBy']);
        }

        $rows = ["<tr>
                <th><a href='./index.php?sortBy=name'>Name</a></th>
                <th><a href='./index.php?sortBy=totalWins'>Siege</a></th>
                <th><a href='./index.php?sortBy=totalSecond'>Zweiter</a></th>
                <th><a href='./index.php?sortBy=totalThird'>Dritter</a></th>
                <th><a href='./index.php?sortBy=totalSitIn'>Teilnahmen</a></th>
                <th><a href='./index.php?sortBy=totalMoney'>Preisgeld</a></th>
                <th><a href='./index.php?sortBy=totalProfit'>Profit</a></th>
                <th><a href='./index.php?sortBy=headsUp'>HeadsUp</a></th>
                <th>HeadsUp Quote</th>
            </tr>"];

        foreach ($ranking as $key => $row) {
            $rowClass = $this->getRowClass($key);
            if($row['totalWins'] == 0) {
                $headsUpQuote = 0;
            }
            if($row['totalWins'] != 0){
                $headsUpQuote = $row['totalWins'] / $row['headsUp'] * 100;
            }
            $rows[] = "<tr class='" . $rowClass . "'>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['totalWins'] . "</td>
                    <td>" . $row['totalSecond'] . "</td>
                    <td>" . $row['totalThird'] . "</td>
                    <td>" . $row['totalSitIn'] . "</td>
                    <td>" . $row['totalMoney']  . "&euro;</td>
                    <td>" . $row['totalProfit'] . "&euro;</td>
                    <td>" . $row['headsUp'] . "</td>
                    <td>" .intval($headsUpQuote) . "%</td>
                    </tr>";
        }
        
        $currentDate = $this->tournaments[count($this->tournaments)-1]->date;
        echo "<table><th>";

        if(isset($_GET['sortBy'])){
            echo $this->tableTitle($_GET['sortBy']);
        }
        else{
            echo 'Profit';
        }
        echo " nach " . count($this->tournaments) . " Turnieren (Stand: ".date('d/m/Y H:i:s', $currentDate).")</th>" . implode('', $rows) . "</table>";
    }

    
    function tableTitle($key)
    {
        switch ($key) {
            case 'name':
                return 'Teilnehmer';
            case 'totalWins':
                return 'Siege';
            case 'totalSecond':
                return 'Zweiter';
            case 'totalThird':
                return 'Dritter';
            case 'totalSitIn':
                return 'Teilnahmen';
            case 'totalMoney':
                return 'Preisgeld';
            case 'totalProfit':
                return 'Profit';
            case 'headsUp':
                return 'HeadsUp';
            default:
                return 'rest';
        }
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
