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
          <link href="https://fonts.googleapis.com/css?family=Allerta+Stencil" rel="stylesheet">
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
        <div class="">
          <div class="container predictionBanner">
            <h4 class="cl-white txt-ctr">Event <?php echo $currentEvent ?></h4>
            
            <!-- <form id="predictionForm" method="post" action="saveBet.php" class="marb-0 txt-ctr mar-auto w-55p"> -->
            <form id="predictionForm" method="post" action="saveBet.php" class="marb-0 ">
            <?php 
              for($i = 0; $i < 2; $i++){
                echo 
                '<div class="match marb-15">
                  <div class="cl-white disp-fl">
                    <div>
                      <p class="marb-0">'.$boxer1[$i].'</p>
                      <p class="pad-5">
                        <input type="checkbox" id="'.$boxer1[$i].'" name="match'.($i+1).'" value="'.$boxer1[$i].'"/>
                        <label for="'.$boxer1[$i].'"><img class="fighters" src="images/fighters/blankFighter.png"/></label>
                      </p>
                    </div>
                    <div class="padt-10p">
                      <input type="checkbox" id="draw'.($i+1).'" name="match'.($i+1).'" value="Draw"/>
                      <label for="draw'.($i+1).'"><img class="" src="images/DRAW1.png" style="height:80px; width:120px"/></label>
                    </div>
                    <div>
                      <p class="marb-0">'.$boxer2[$i].'</p>
                      <p class="pad-5">
                        <input type="checkbox" id="'.$boxer2[$i].'" name="match'.($i+1).'" value="'.$boxer2[$i].'"/>                        
                        <label for="'.$boxer2[$i].'"><img class="fighters" src="images/fighters/blankFighter.png"/></label>
                      </p>
                    </div> 
                  </div> 
                  <div class="clearfix"></div>
                  <div><label for="match'.($i+1).'Round" class="cl-white">Predict match to end on rounds or points : </label>
                    <select name="match'.($i+1).'Round">';
                    for($rs = 1; $rs < 13; $rs++){
                      echo '<option value="'.$rs.'">Round '.$rs.'</option>';
                    }
                    echo '<option value="13">Points</option>
                    </select>
                  </div>
                </div>'; };
                echo '<div class="mart-10">
                <label for="goldenGlove" class="cl-gold">Golden Glove Prediction : </label>
                  <select name="goldenGlove">';
                  for($i = 0; $i < count($boxer1); $i++){
                    echo '<option value="'.$boxer1[$i].' vs '.$boxer2[$i].'">'.$boxer1[$i].' vs '.$boxer2[$i].'</option>';
                  };
              echo '</select></div>
              <input type="submit" value="Submit Predictions" class="jab6Btn mar-10 fs-18 mart-30"/>';              
            ?>

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
