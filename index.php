<?php
include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

spl_autoload_register(function($className){
  $className = strtolower($className);
  require __DIR__."/classes/$className.php";
});

// $alice = new User("Alice", "Palmer", "1994-12-18", "alicerose1812", "hello", "alicerosepalmer123@hotmail.co.uk", "07715963802", 1, 0);
// echo $alice->getMe();

date_default_timezone_set('Europe/London');

$results = array(
    array("Mayweather", 10),
    array("Ward", 13),
    array("Draw", 13),
    array("Joshua", 5),
    array("Froch", 8),
    array("Haye", 10),
    0
);

$betByTime = strtotime("+1 minute", time());
$betBySerialize = serialize($betByTime);
// save serialized data in a text file
file_put_contents('betBy.txt', $betBySerialize);

$betsSerialize = serialize(array());
// save serialized data in a text file
file_put_contents('bets.txt', $betsSerialize);


$serializedData = serialize($results);
// save serialized data in a text file
file_put_contents('results.txt', $serializedData);

?>
<html>
  <head>
    <title>Jab 6 Boxing</title>
  </head>
  <body>
    <h1>Jab 6 Boxing</h1>
    <?php
    if(isset($_SESSION['login'])){
      ?>
      <a href="logic/logout.php" style="float:right;width:70%">Logout</a>

        <?php 
          $boxer1 = []; 
          $boxer2 = [];
          $currentEvent = 0;
          $currentTime = new datetime('2017-03-01');
          $currentTime->setTime(21,00,00);
          // echo $currentTime->format('Y-m-d H:i:s');
          // echo "<br>";
          // echo date_timestamp_get($currentTime);
          // echo "<br>";

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
                 // echo $row['matchName'];
                 // echo "<br>";
                $boxerArray = explode(" ", $row['matchName']); 
                array_push($boxer1, $boxerArray[0]);
                array_push($boxer2, $boxerArray[2]);

                }
                break; 
              }
            }  
           // var_dump($boxer1);
           // var_dump($boxer2);


        ?>

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

      <?php
    } else {
      ?>
      <p>Login</p>
      <p>
        <a href="register.php">Register</a>
      </p>

      <form method="post" action="logic/checklogin.php">
        <label>Username</label>
        <input type="text" name="userName"/>
        <br/>
        <label>Password</label>
        <input type="password" name="password"/>
        <br/>
        <input type="submit"/>
      </form>

      <?php
    }
    ?>


  </body>
</html>
