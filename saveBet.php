<?php
//Include sessions and sql connection
include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');
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
        <?php
                //Include the sky betting and gaming product header and the nav bar
                include('includes/productHeader.inc.php');
                include('includes/navBar.inc.php');

                //autoload classes whenever a new object is created
                spl_autoload_register(function($className){
                  $className = strtolower($className);
                  require __DIR__."/classes/$className.php";
                });

                //Set the timezone to london time and get the current time and date
                date_default_timezone_set('Europe/London');
                $time = explode(" ",date('Y-m-d H:i:s'));
                $currentDate = $time[0];
                $currentTime = $time[1];
                $userId = "";
        ?>
        <div>
            <div class="container">
                <?php
                  //if the user session is set store the user in the user variable and the userId in the userId variable
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
                      echo '
                      <div class="contentBanner">
                        <div class="txt-ctr cl-white padt-20p">
                          <h3>Your prediction has been placed and saved</h3>
                          <h3>Good Luck!</h3>
                        </div>
                      </div>
                      ';
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
                      echo '
                        <div class="contentBanner">
                          <div class="txt-ctr cl-white padt-20p">
                            <h3>Your bet has been updated</h3>
                            <h3>Good Luck!</h3>
                          </div>
                        </div>
                      ';
                    }
                  }else{
                    echo'
                      <div class="contentBanner">
                        <div class="txt-ctr cl-white padt-20pr">
                          <h3>Please log in to make a prediction</h3>
                        </div>
                      </div>
                    ';
                  }
                ?>
            </div>
        </div>
    </body>

    <?php
    //Include the footer on the page
    include_once('includes/footer.inc.php');
    ?>

    <script src="js/jQuery/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/smoothScroll/smoothScroll.js"></script>
</html>
