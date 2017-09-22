<?php
include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

spl_autoload_register(function($className){
  $className = strtolower($className);
  require __DIR__."/classes/$className.php";
});


date_default_timezone_set('Europe/London');

$time = explode(" ",date('Y-m-d H:i:s'));
$currentDate = $time[0];
$currentTime = $time[1];
$userId = "";

if(isset($_SESSION['user'])){
  $user = unserialize (serialize ($_SESSION['user']));
  $result = $user->getId();
  foreach($result as $i){
    $userId = $i['userId'];
    break;
  }
  
  $p = $pdo->prepare("insert into userPrediction (userId, eventId, tiebreakerPrediction, date, time)
  values (:userId, :eventId, :tiebreakerPrediction, :date, :time)");

  $p->execute([
    'userId' => $userId,
    'eventId' => $_SESSION['currentEvent'],
    'tiebreakerPrediction' => $_POST['goldenGlove'],
    'date' => $currentDate,
    'time' => $currentTime
  ]);

  $predictionId = $pdo->lastInsertId();
  for($i=1; $i<7; $i++){
    $round = $_POST["match".$i."Round"];
    $name = "match".$i;
    $fighter = $_POST[$name];
    $m = $pdo->prepare("insert into userMatchPredictions (predictionId, matchId, predictedResult, predictedRound)
    values (:predictionId, :matchId, :predictedResult, :predictedRound)");

    $m->execute([
      'predictionId' => $predictionId,
      'matchId' => $i,
      'predictedResult' => $fighter,
      'predictedRound' => $round
    ]);
  }  
}
?>
