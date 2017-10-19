<?php
include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

spl_autoload_register(function($className){
  $className = strtolower($className);
  require __DIR__."/classes/$className.php";
});

if(isset($_SESSION['login'])){

    $getUser = $pdo->query(
      "select userName, points from users
      order by points DESC LIMIT 10"
    );

    $noOfEvents = $pdo->query(
      "select MAX(eventId) from userPoints"
    );

    $getPoints = $pdo->query(
      "select users.userName, userPoints.points, userPoints.eventId from users join userPoints on users.userId = userPoints.userId
      order by points DESC LIMIT 10"
    );

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
      <?php include_once('includes/productHeader.inc.php');
            include_once('includes/navBar.inc.php'); 
        ?>

        <div class="container" style="min-height: 700px">
        
        <div align="center" style="margin-top:2%">
        <h1>Jab6 Boxing Leaderboard</h1>
        <strong><i>Leaderboard standings are calculated as per the game rules at the end of each round.</i></strong>
        </div>

        <div>
        <h3><b>All Time Points <i>(Top 10)</i></b></h3>

        <table width="1120">
          <tr>
            <td>Username</td>
            <td>Points</td>
          </tr>

            <?php
            foreach ($getUser as $user) {
              ?>
              <tr>
                <td><?php echo $user['userName'] ?></td>
                <td><?php echo $user['points'] ?></td>
              </tr>
              <?php
            }
            ?>
        </table>
        </div> 
        
        <div style="margin-top:5%">
        <h3><b>Points by Event <i>(Top 10)</i></b></h3>
        <form method="get" action="">
          <select name="eventId" onchange="this.form.submit()">
            <?php
            foreach ($noOfEvents as $events) {
              for($i = 1; $i <= $events['MAX(eventId)']; $i++){
                if(isset($_GET['eventId'])){
                  if($_GET['eventId'] == $i){
                    ?>
                    <option selected value="<?php echo $i ?>">Event <?php echo $i ?></option>
                    <?php
                  } else {
                    ?>
                    <option value="<?php echo $i ?>">Event <?php echo $i ?></option>
                    <?php
                  }
                } else {
                  ?>
                  <option value="<?php echo $i ?>">Event <?php echo $i ?></option>
                  <?php
                }
              }
            }
            ?>
          </select>
        </div>
      </form>

        <?php
        if(isset($_GET['eventId'])){
          $eventChosen = $_GET['eventId'];
        } else {
          $eventChosen = 1;
        }

        ?>
        <table id="leaderboard" width="1120">
          <tr>
            <td>Username</td>
            <td>Points</td>
          </tr>
          <?php
          foreach ($getPoints as $points) {
            if($points['eventId'] == $eventChosen){
            ?>
              <tr>
                <td><?php echo $points['userName'] ?></td>
                <td><?php echo $points['points'] ?></td>
              </tr>
            <?php
            }
          }
          ?>
        </table>
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

