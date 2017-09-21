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
      order by points DESC"
    );

    $noOfEvents = $pdo->query(
      "select MAX(eventId) from userPoints"
    );

    $getPoints = $pdo->query(
      "select users.userName, userPoints.points, userPoints.eventId from users join userPoints on users.userId = userPoints.userId
      order by points DESC"
    );

    ?>
    <html>
      <head>
        <title>Jab 6 Boxing</title>
      </head>
      <body>
        <h1>Jab 6 Boxing</h1>
        <h2>Leaderboard</h2>
        <h3>All Time Points</h3>
        <table>
          <tr>
            <th>Username</th>
            <th>Points</th>
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
        <h3>Points by Event</h3>
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
        </form>

        <?php
        if(isset($_GET['eventId'])){
          $eventChosen = $_GET['eventId'];
        } else {
          $eventChosen = 1;
        }

        ?>
        <table>
          <tr>
            <th>Username</th>
            <th>Points</th>
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

      </body>
    </html>
    <?php


} else {
  header ('Location: index.php');
}



?>
