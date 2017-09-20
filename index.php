<?php
include('includes/sessions.inc.php');
// include('classes/user.php');
spl_autoload_register(function($className){
  $className = strtolower($className);
  require __DIR__."/classes/$className.php";
});

$alice = new User("Alice", "Palmer", "1994-12-18", "alicerose1812", "hello", "alicerosepalmer123@hotmail.co.uk", "07715963802", 1, 0);
echo $alice->getMe();

date_default_timezone_set('Europe/London');

$results = array(
    array("may", 8),
    array("jake", 8),
    array("mcgreg", 2),
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
          <input type="radio" name="match1" value="may"> Mayweather<br>
          <input type="radio" name="match1" value="bobby"> Bobby<br>
          <input type="radio" name="match1" value="draw"> Draw<br>
          <select name="match1Round">
            <?php for($i = 1; $i < 13; $i++){ ?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php } ?>
              <option value="13">Points</option>
          </select>
        </div>

        <div class="match">
          <input type="radio" name="match2" value="barry"> Barry<br>
          <input type="radio" name="match2" value="jake"> Jake<br>
          <input type="radio" name="match2" value="draw"> Draw<br>
          <select name="match2Round">
            <?php for($i = 1; $i < 13; $i++){ ?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php } ?>
              <option value="13">Points</option>
          </select>
        </div>

        <div class="match">
          <input type="radio" name="match3" value="mcgreg"> Mcgreggor<br>
          <input type="radio" name="match3" value="jeff"> Jeff<br>
          <input type="radio" name="match3" value="draw"> Draw<br>
          <select name="match3Round">
            <?php for($i = 1; $i < 13; $i++){ ?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php } ?>
              <option value="13">Points</option>
          </select>
        </div>

        <div class="goldenGlove">
          <select name="goldenGlove">
              <option value="0">Mayweather v Bobby</option>
              <option value="1">Barry v Jake</option>
              <option value="2">Mcgreggor v Jeff</option>
          </select>
        </div>

        <input type="submit"/>


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
