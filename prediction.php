<?php
include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

if(isset($_SESSION['login'])){ ?>
  <html>
      <head>
          <title>Jab 6 Boxing</title>
          <meta charset="utf-8">
          <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
          <link rel="stylesheet" type="text/css" href="css/font-awesome-4.7.0/css/font-awesome.min.css"/>
          <link rel="stylesheet" type="text/css" href="css/jab6style.css"/>
      </head>
      <body id="top">
        <?php include_once('includes/productHeader.inc.php'); 
              include_once('includes/navBar.inc.php'); 
          date_default_timezone_set('Europe/London');
          $boxer1 = []; 
          $boxer2 = [];
          $currentEvent = 0;
          $currentTime = new datetime('2017-03-01');
          $currentTime->setTime(21,00,00);

          $r = $pdo->query("select * from event");
          foreach($r as $row){
            $dateTime = explode(" ", $row["startTime"]);
            $eventTime = new datetime($dateTime[0]);
            $eventTime->setTime(21,00,00);
            $eventTime->format('Y-m-d H:i:s');
            $eventTime = date_timestamp_get($eventTime);

              
            if ($currentTime < $eventTime){
                $currentEvent = $row["eventId"]; 

                $r = $pdo->prepare("select matchName from boxingMatches where eventId = :currentEvent");
                $r->execute(['currentEvent'=>$currentEvent]);
                foreach($r as $row){
                $boxerArray = explode(" ", $row['matchName']); 
                array_push($boxer1, $boxerArray[0]);
                array_push($boxer2, $boxerArray[2]);

                }
                break; 
              }
            }  
          ?>
        <div class="predictionBanner">
          <div class="container">
            
            <form id="predictionForm" method="post" action="saveBet.php" class="marb-0 txt-ctr mar-auto w-55p">
            <h4 class="cl-white txt-ctr">
              Event 1
            </h4>
              <div class="match marb-15">
                  <div class="cl-white disp-fl">
                    <div>
                      <p class="marb-0">
                        Mcgregor
                      </p>
                      <p class="pad-5">
                        <input type="checkbox" id="Mcgregor" name="match1" value="McGregor"/>
                        <label for="Mcgregor"><img class="fighters" src="images/fighters/blankFighter.png"/></label>
                      </p>
                    </div>
                    <div class="padt-10p">
                      <input type="checkbox" id="draw1" name="match1" value="Mayweather"/>
                      <label for="draw1"><img class="" src="images/DRAW1.png" style="height:80px; width:120px"/></label>
                    </div>
                    <div>
                      <p class="marb-0">
                        Mayweather
                      </p>
                      <p class="pad-5">
                        <input type="checkbox" id="Mayweather" name="match1" value="Mayweather"/>
                        <label for="Mayweather"><img class="fighters" src="images/fighters/blankFighter.png" /></label>
                      </p>
                    </div>
                  </div>  
                  <div class="clearfix"></div>
                  <div class="">
                    <label for="match1Round" class="cl-white">Predict match to end on rounds or points : </label>
                    <select name="match1Round">
                      <option value="1">Round 1</option>
                      <option value="2">Round 2</option>
                      <option value="3">Round 3</option>
                      <option value="4">Round 4</option>
                      <option value="5">Round 5</option>
                      <option value="6">Round 6</option>
                      <option value="7">Round 7</option>
                      <option value="8">Round 8</option>
                      <option value="9">Round 9</option>
                      <option value="10">Round 10</option>
                      <option value="11">Round 11</option>
                      <option value="12">Round 12</option>
                      <option value="13">Points</option>
                    </select>
                  </div>
              </div>
              
              <div class="mart-10">
                <label for="goldenGlove" class="cl-gold">Golden Glove Prediction : </label>
                <select name="goldenGlove">
                  <option value="0">McGregor vs Mayweather</option>
                  <option value="1">Ward vs Jacobs</option>
                  <option value="2">Golovkin vs Canelo</option>
                  <option value="3">Joshua vs Fury</option>
                  <option value="4">Groves vs Froch</option>
                  <option value="5">Bellew vs Haye</option>
                </select>
              </div>

              <input type="submit" value="Submit Predictions" class="jab6Btn mar-10 fs-18 mart-30" style=""/>
            </form>
            <p class=" txt-ctr padl-20p padr-20p fs-14">
              The fight that will finish earliest out of the six selected matches. 
              Your Golden Glove prediction will be used if a tie breaker is needed. 
              For more information see FAQs.
            </p>
          </div>
        </div>
      </body>
      
      <?php   include_once('includes/footer.inc.php');?>

      <script src="js/jQuery/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="js/smoothScroll/smoothScroll.js"></script>
  </html>

<?php   
} else {
  header ('Location: index.php');
}?>
