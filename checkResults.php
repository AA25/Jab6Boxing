<?php

include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

spl_autoload_register(function($className){
  $className = strtolower($className);
  require __DIR__."/classes/$className.php";
});

date_default_timezone_set('Europe/London');

if(isset($_SESSION['user'])){
  $user = unserialize (serialize ($_SESSION['user']));
  $result = $user->getId();
  foreach($result as $i){
    $userId = $i['userId'];
    break;
  }

  $c = $pdo->prepare("select count(1) from userPrediction where userId = :userId AND eventId = :eventId");
  $c->execute([
    'userId' => $userId,
    'eventId' => $_SESSION['currentEvent']
    ]);
  $exists = $c->fetch();

  if($exists[0] ==  1){

    $c = $pdo->prepare("select tiebreakerPrediction, predictionId from userPrediction where userId = :userId AND eventId = :eventId");
    $c->execute([
      'userId' => $userId,
      'eventId' => $_SESSION['currentEvent']
    ]);
    $userPrediction = $c->fetch();

    $c = $pdo->prepare("select * from userMatchPredictions where predictionId = :predictionId");
    $c->execute([
      'predictionId' => $userPrediction['predictionId'],
    ]);

    $userPredictions = $c;

    $c = $pdo->prepare("select individualMatchId, result, round, duration, matchName from boxingMatches where eventId = :eventId");
    $c->execute([
      'eventId' => $_SESSION['currentEvent'],
    ]);

    $matchResults = $c->fetchAll();

    $c = $pdo->prepare("select matchName from boxingMatches where eventId = :eventId order by duration limit 1");
    $c->execute([
      'eventId' => $_SESSION['currentEvent'],
    ]);

    $shortestMatch = $c->fetch();

    $tiebreaker = false;

    if($shortestMatch['matchName'] == $userPrediction['tiebreakerPrediction']){
      $tiebreaker = true;
    }

    $points = 0;

    foreach ($userPredictions as $prediction) {

      $option1 = 0; $option2 = 0;

      for($i = 0; $i < 6; $i++){
        if($prediction['matchId'] == $matchResults[$i]['individualMatchId']){

          if($prediction['predictedResult'] == $matchResults[$i]['result']){
            $option1++;
          }
          if($prediction['predictedRound'] == $matchResults[$i]['round']){
            $option2++;
          }

          if ($option1 == 1 && $option2 == 1){
            $points += 5;
          }
          elseif($option1 == 1 && $option2 == 0){
            $points += 2;
          }
        }

      }

    }

    ?>

    <html>
        <head>
            <title>Jab 6 Boxing</title>
            <meta charset="utf-8">
            <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="css/font-awesome-4.7.0/css/font-awesome.min.css"/>
            <link rel="stylesheet" type="text/css" href="css/jab6style.css"/>
            <link rel="icon" href="images/favicon.ico" type="image/x-icon">
        </head>
        <body id="top">
            <?php   include_once('includes/productHeader.inc.php');
                    include_once('includes/navBar.inc.php');
            ?>
            <div class="contentBanner ">
              <div class="container">
              <h2 style="text-align: center; color: white;">Your results for this round</h2>
              <div class="row center txt-ctr" style="margin-top:19%">
    <?php

    if($points == 30){
      ?><p style="text-align: center; color: white;"><?php echo $user->getFirstName() . " you have won the Jab6 jackpot!!!"; ?></p><?php
    } else {
      ?><p style="text-align: center; color: white;"><?php echo $user->getFirstName() . " you scored " . $points . " points!"; ?></p><?php
    }

    if($tiebreaker){
      ?><p style="text-align: center; color: white;"><?php echo "You got the tiebreaker!"; ?></p><?php
    } else {
      ?><p style="text-align: center; color: white;"><?php echo "You didn't get the tiebreaker"; ?></p><?php
    }

    ?>
          </div>
        </div>
      </div>
    </body>
    <?php   include_once('includes/footer.inc.php');?>
  </html>

    <?php


  } else {

    //prediction doesn't exist

  }

}

?>
