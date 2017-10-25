<?php
//Include sessions and sql connection
include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

//autoload classes whenever a new object is created
spl_autoload_register(function($className){
  $className = strtolower($className);
  require __DIR__."/classes/$className.php";
});

//Set the timezone to london time
date_default_timezone_set('Europe/London');

//if the user session is set store the user in the user variable and the userId in the userId variable
if(isset($_SESSION['user'])){
  $user = unserialize (serialize ($_SESSION['user']));
  $result = $user->getId();
  foreach($result as $i){
    $userId = $i['userId'];
    break;
  }

  //Get the number of predictions the user has made for the current event
  $c = $pdo->prepare("select count(1) from userPrediction where userId = :userId AND eventId = :eventId");
  $c->execute([
    'userId' => $userId,
    'eventId' => $_SESSION['currentEvent']
    ]);
  $exists = $c->fetch();

  //If the user has made a prediction for the current event
  if($exists[0] ==  1){

    //Get the tiebreaker prediction and predictionId for the current user and the current event
    $c = $pdo->prepare("select tiebreakerPrediction, predictionId from userPrediction where userId = :userId AND eventId = :eventId");
    $c->execute([
      'userId' => $userId,
      'eventId' => $_SESSION['currentEvent']
    ]);
    $userPrediction = $c->fetch();

    //Get all the match predictions from the current user for the current event
    $c = $pdo->prepare("select * from userMatchPredictions where predictionId = :predictionId");
    $c->execute([
      'predictionId' => $userPrediction['predictionId'],
    ]);

    $userPredictions = $c;

    //Get the results from the matches for the current event
    $c = $pdo->prepare("select individualMatchId, result, round, duration, matchName from boxingMatches where eventId = :eventId");
    $c->execute([
      'eventId' => $_SESSION['currentEvent'],
    ]);

    $matchResults = $c->fetchAll();

    //Get the match that finished first for the tiebraker
    $c = $pdo->prepare("select matchName from boxingMatches where eventId = :eventId order by duration limit 1");
    $c->execute([
      'eventId' => $_SESSION['currentEvent'],
    ]);

    $shortestMatch = $c->fetch();

    $tiebreaker = false;
    //If the tiebraker prediction was the same as the result set the tiebraker variable to true
    if($shortestMatch['matchName'] == $userPrediction['tiebreakerPrediction']){
      $tiebreaker = true;
    }

    $points = 0;

    //For each of the users predictions check to see if they match the result and round
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
              <div class="row center txt-ctr" style="margin-top:19%">
              <h2 style="text-align: center; color: white;">Your results for this round</h2>
    <?php

    if($points == 30){
      ?><p style="text-align: center; color: white;"><?php echo $user->getFirstName() . " you have won the Jab6 Jackpot Prize!!!"; ?></p><?php
    } else {
      ?><p style="text-align: center; color: white;"><?php echo $user->getFirstName() . " you scored " . $points . " points!"; ?></p><?php
    }

    if($tiebreaker){
      ?><p style="text-align: center; color: white;"><?php echo "Your tiebreaker prediction was correct!"; ?></p><?php
    } else {
      ?><p style="text-align: center; color: white;"><?php echo "Your tiebreaker prediction was incorrect."; ?></p><?php
    }

    ?>
            <form action="updatePoints.php" method="post">
              <input type="hidden" name="points" value="<?php echo $points ?>"/>
              <input type="submit" value="Update Results" id="playBtn" class="btn bord-rd fs-18"/>
            </form>
          </div>
        </div>
      </div>
    </body>
    <?php
    //Include footer
    include_once('includes/footer.inc.php');
    ?>
  </html>

    <?php


  } else {

    //If a prediction doesn't exist redirect to home page
    header("location:index.php");

  }

} else {
  //If the user isn't logged in redirect to home page
  header("location:index.php");
}

?>
