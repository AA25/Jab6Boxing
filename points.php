<?php
//This file is not used!!! 
   include_once('includes/sessions.inc.php');
   include('includes/sqlConnect.inc.php');

   spl_autoload_register(function($className){
    $className = strtolower($className);
    require __DIR__."/classes/$className.php";
});

// gets current user and userId 
   if(isset($_SESSION['user'])){
    $user = unserialize (serialize ($_SESSION['user']));
    $result = $user->getId();
    foreach($result as $i){
      $userId = $i['userId'];
      break;
    }
}
// gets current users prediction    
$p = $pdo->prepare("select * from userPrediction where userId = :userId AND eventId = :eventId");
$p->execute([
    'userId' => $userId,
    'eventId' => 1
]);
$userPrediction = $p->fetch(); 

$id = $pdo->prepare("select predictionId from userPrediction where userId = :userId AND eventId = :eventId");
$id->execute([    
  'userId' => $userId,
  'eventId' => 1
]);
$predictionId = $id->fetch(); 
$matchPredicitionsArray = [];

for($i=1; $i<7; $i++){
  $m = $pdo->prepare("select * from userMatchPredictions where predictionId = :predictionId AND matchId = :matchId");

  $m->execute([
    'predictionId' => $predictionId[0],
    'matchId' => $i,
  ]);
$matchPrediction = $m->fetch();
$matchPredictionsArray[$i-1] = $matchPrediction;
}  

$matchResultsArray = [];
for ($i=1; $i<7; $i++){
    $r = $pdo->prepare("select * from boxingMatches where individualMatchId = :individualMatchId AND eventId = :eventId");
    $r->execute([
    'individualMatchId' => $i,
    'eventId' => 1
    ]);
    $matchResults = $r->fetch();
    $matchResultsArray[$i-1] = $matchResults;
} 
$points = array();
for($i = 0; $i<6; $i++){
    $option1 = 0; 
    $option2 = 0;
    if($matchResultsArray[$i]["result"] == $matchPredictionsArray[$i]["predictedResult"]){
        $option1++; 
    }

    if($matchResultsArray[$i]["round"] == $matchPredictionsArray[$i]["predictedRound"]){
        $option2++;
    }
    echo $matchResultsArray[$i]["result"] . " " . $matchPredictionsArray[$i]["predictedResult"] . "<br>";
    echo $matchResultsArray[$i]["round"] . " " . $matchPredictionsArray[$i]["predictedRound"] . "<br><br>";
    if ($option1 == 1 && $option2 == 1){
        array_push($points, 5);
      }
      elseif($option1 == 1 && $option2 == 0){
        array_push($points, 2);
      }
      else{
        array_push($points, 0);
      }
}
if(($points[0] + $points[1] + $points[2] + $points[3] + $points[4] + $points[5]) == 30){
    echo " You have won the Jab6 Jackpot!!!";
  } else {
    echo " You scored " . ($points[0] + $points[1] + $points[2] + $points[3] + $points[4] + $points[5]) . " points! <br>";

  }
?>
<h3>Points Breakdown</h3>
<?php
    echo "In <b>Match 1</b>, you scored " .'<b>'. $points[0] .'</b>'. " points <br>";
    echo "In <b>Match 2</b>, you scored " .'<b>'. $points[1] .'</b>'. " points <br>";
    echo "In <b>Match 3</b>, you scored " .'<b>'. $points[2] .'</b>'. " points <br>";
    echo "In <b>Match 4</b>, you scored " .'<b>'. $points[3] .'</b>'. " points <br>";
    echo "In <b>Match 5</b>, you scored " .'<b>'. $points[4] .'</b>'. " points <br>";
    echo "In <b>Match 6</b>, you scored " .'<b>'. $points[5] .'</b>'. " points <br>";
?>