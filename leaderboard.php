<?php
//Include sessions and sql connection
include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

//autoload classes whenever a new object is created
spl_autoload_register(function($className){
  $className = strtolower($className);
  require __DIR__."/classes/$className.php";
});

//If the user is logged in
if(isset($_SESSION['login'])){

    //Get the user information from the db
    $getUser = $pdo->query(
      "select userName, points from users
      order by points DESC LIMIT 10"
    );

    //Get the number of events the user has made predictions in
    $noOfEvents = $pdo->query(
      "select MAX(eventId) from userPoints"
    );

    //Get the points all users have recieved
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

      <body id="top" style="color: white;">
        <?php
        //Include the sky betting and gaming product header and the nav bar
        include_once('includes/productHeader.inc.php');
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
            //For every user display their username and their points total
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
          <select style="color: black;" name="eventId" onchange="this.form.submit()">
            <?php
            //For each event display a dropdown option for the user to switch the event leaderboard they are seeing
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
        //If an event has been selected from the dropdown then get what event has been selected. Otherwise set the event to 1
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
          //For each user display the points they got from the event selected
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

      <?php
      //Include the footer
      include_once('includes/footer.inc.php');
      ?>

      <script src="js/jQuery/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="js/smoothScroll/smoothScroll.js"></script>
    </html>
    <?php


} else {
  //If the user is not logged in redirect them back to the home page
  header ('Location: index.php');
}

?>
