<?php

//Turnier Klasse erstellen
require "./turnier.php";
require "./ranking.php";

$ranking = new Ranking();
$ranking->loadTournaments();

?>

<html>
<head>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="./styles.css">
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script><?php
    echo "var rankingData = " . $ranking->getRankingData() . ";";
    echo "var tournamentData = " . $ranking->getTournamentData() . ";";
    ?>
  </script>
  <script src="./chart.js"></script>
</head>
<body>
<br>

<?php

//$ranking->printTournaments();
$ranking->printRankingProfit();
//echo '<pre>'.print_r($ranking->getRankingData()).'</pre>'; 

?>

<div id="chart-container" style="width:100%; height:800px;"></div>

</body>
</html>
