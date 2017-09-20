<?php
include('includes/sessions.inc.php');
// include('classes/user.php');
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
      <a href="logic/logout.php">Logout</a>

      <div class="container">
      <form method="post" action="saveBet.php">

        <div class="match">
        <div style= "float:left;width:15%">
         <b><input type="radio" name="match1" value="McGregor"> McGregor<br></b>
         <b><input type="radio" name="match1" value="Mayweather"> Mayweather<br></b>
         <b><input type="radio" name="match1" value="Draw"> Draw<br></b>
          <select name="match1Round">
            <?php for($i = 1; $i < 13; $i++){ ?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php } ?>
              <option value="13">Points</option>
          </select>
        </div>

        <div class="match">
          <b><input type="radio" name="match2" value="Ward"> Ward<br></b>
          <b><input type="radio" name="match2" value="Jacobs"> Jacobs<br></b>
          <b><input type="radio" name="match2" value="Draw"> Draw<br></b>
          <select name="match2Round">
            <?php for($i = 1; $i < 13; $i++){ ?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php } ?>
              <option value="13">Points</option>
          </select>
        </div>
        <br>

        <div class="match">
        <div style= "float:left;width:15%">
          <b><input type="radio" name="match3" value="Golovkin"> Golovkin<br></b>
          <b><input type="radio" name="match3" value="Canelo"> Canelo<br></b>
          <b><input type="radio" name="match3" value="Draw"> Draw<br></b>
          <select name="match3Round">
            <?php for($i = 1; $i < 13; $i++){ ?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php } ?>
              <option value="13">Points</option>
          </select>
        </div>

        <div class="match">
          <b><input type="radio" name="match4" value="Joshua"> Joshua<br></b>
          <b><input type="radio" name="match4" value="Fury"> Fury<br></b>
          <b><input type="radio" name="match4" value="Draw"> Draw<br></b>
          <select name="match4Round">
            <?php for($i = 1; $i < 13; $i++){ ?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php } ?>
              <option value="13">Points</option>
          </select>
        </div>
        <br>

        <div class="match">
        <div style= "float:left;width:15%">
          <b><input type="radio" name="match5" value="Froch"> Froch<br></b>
          <b><input type="radio" name="match5" value="Groves"> Groves<br></b>
          <b><input type="radio" name="match5" value="Draw"> Draw<br></b>
          <select name="match5Round">
            <?php for($i = 1; $i < 13; $i++){ ?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php } ?>
              <option value="13">Points</option>
          </select>
        </div>

        <div class="match">
          <b><input type="radio" name="match6" value="Haye"> Haye<br></b>
          <b><input type="radio" name="match6" value="Bellew"> Bellew<br></b>
          <b><input type="radio" name="match6" value="Draw"> Draw<br></b>
          <select name="match6Round">
            <?php for($i = 1; $i < 13; $i++){ ?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php } ?>
              <option value="13">Points</option>
          </select>
        </div>
        <br>
              
        <strong>Golden Glove Prediction</strong>
        <div class="goldenGlove">
          <select name="goldenGlove">
              <option value="0">McGregor vs Mayweather</option>
              <option value="1">Ward vs Jacobs</option>
              <option value="2">Golovkin vs Canelo</option>
              <option value="3">Joshua vs Fury</option>
              <option value="4">Froch vs Groves</option>
              <option value="5">Haye vs Bellew</option>
          </select>
        </div>
        <br><i>The fight that will finish earliest out of the six selected matches. <br>
        Your Golden Glove prediction will be used if a tie breaker is needed. <br>
        For more information see FAQs.</strong></i><br><br>
        <input type="submit" style="width:100px; height:80px;"/>


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
        <input type="text" name="username"/>
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
