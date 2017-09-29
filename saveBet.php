<?php
include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

spl_autoload_register(function($className){
  $className = strtolower($className);
  require __DIR__."/classes/$className.php";
});


// for($i=1; $i<7; $i++){
//   $round = $_POST["match".$i."Round"];
//   $name = "match".$i;
//   $fighter = $_POST[$name];
//   echo $name.'<br>'.$fighter.'<br>'.$round.'<br>';
// }  


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
  
  // check if prediction already exists 
  $c = $pdo->prepare("select count(1) from userPrediction where userId = :userId AND eventId = :eventId");
  $c->execute([
    'userId' => $userId,
    'eventId' => $_SESSION['currentEvent']
    ]);
  $exists = $c->fetch();
  //echo $exists[0];
  // update predictions in userPredictions 
  if ($exists[0] == 0){
    $p = $pdo->prepare("insert into userPrediction (userId, eventId, tiebreakerPrediction, date, time)
    values (:userId, :eventId, :tiebreakerPrediction, :date, :time)");
  
    $p->execute([
      'userId' => $userId,
      'eventId' => $_SESSION['currentEvent'],
      'tiebreakerPrediction' => $_POST['goldenGlove'],
      'date' => $currentDate,
      'time' => $currentTime
    ]);
  // insert predictions into userMatchPredictions
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
  } else {
    // update predictions in userPrediction     
    $u = $pdo->prepare("update userPrediction set tiebreakerPrediction = :tiebreakerPrediction, date = :date, time = :time where userId = :userId AND eventId = :eventId");
    $u->execute([
      'userId' => $userId,
      'eventId' => $_SESSION['currentEvent'],
      'tiebreakerPrediction' => $_POST['goldenGlove'],
      'date' => $currentDate,
      'time' => $currentTime

    ]);
    $id = $pdo->prepare("select predictionId from userPrediction where userId = :userId AND eventId = :eventId");
    $id->execute([    
      'userId' => $userId,
      'eventId' => $_SESSION['currentEvent']
    ]);
    // update predictions in userMatchPredictions
    $predictionId = $id->fetch();
    for($i=1; $i<7; $i++){
      $round = $_POST["match".$i."Round"];
      $name = "match".$i;
      $fighter = $_POST[$name];
      $m = $pdo->prepare("update userMatchPredictions set predictedResult = :predictedResult, predictedRound = :predictedRound where predictionId = :predictionId AND matchId = :matchId");
  
      $m->execute([
        'predictionId' => $predictionId[0],
        'matchId' => $i,
        'predictedResult' => $fighter,
        'predictedRound' => $round
      ]);
    }  
  }
}
?>
