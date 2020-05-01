
  <html>
  <head>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./style.css">
  </head>
  <body>

<?php 
  
//Turnier Klasse erstellen
require "./turnier.php";
require "./ranking.php";


$ranking = new Ranking();
$ranking->loadTournaments();
$ranking->printTournaments();

?>
<br>
<?php
$ranking->printRanking();

?>


</body>
</html>