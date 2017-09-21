<?php
include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

if(isset($_SESSION['login'])){
  ?>
  <html>
      <head>
          <title>Jab 6 Boxing</title>
          <meta charset="utf-8">
          <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
          <link rel="stylesheet" type="text/css" href="css/font-awesome-4.7.0/css/font-awesome.min.css"/>
          <link rel="stylesheet" type="text/css" href="css/fab6style.css"/>
      </head>
      <body id="top">
        <?php   include_once('includes/productHeader.inc.php');
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
          <div class="container">
            <form method="post" action="">
              <?php 
              for($i = 0; $i < count($boxer1); $i++){
                echo '<div class="match">
                        <b><input type="radio" name="match '.$i.'" value="'.$boxer1[$i].'">'.$boxer1[$i].'<br></b>
                        <b><input type="radio" name="match '.$i.'" value="'.$boxer2[$i].'">'.$boxer2[$i].'<br></b>
                        <b><input type="radio" name="match '.$i.'" value="Draw">Draw<br></b>
                        <select name="match'.$i.'Round">';
                    for($rs = 1; $rs < 13; $rs++){
                      echo '<option value="'.$rs.'">'.$rs.'</option>';
                    }
                      echo '<option value="13">Points</option></select></div><br>'; 
              }

              echo '<font color="gold"><strong>Golden Glove Prediction</strong></font>
              <div class="goldenGlove">
                <select name="goldenGlove">';

                for($i = 0; $i < count($boxer1); $i++){
                    echo '<option value="'.$i.'">'.$boxer1[$i].' vs '.$boxer2[$i].'</option>';
                }
              echo '</select>
              </div>';

              echo '<br><i>The fight that will finish earliest out of the six selected matches. <br>
              Your Golden Glove prediction will be used if a tie breaker is needed. <br>
              For more information see FAQs.</strong></i><br><br>
              <input type="submit" style="width:100px; height:80px;"/>';
              ?>
            </form>
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
}
 ?>
