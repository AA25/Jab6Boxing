<?php
include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

spl_autoload_register(function($className){
  $className = strtolower($className);
  require __DIR__."/classes/$className.php";
});

if(isset($_SESSION['login'])){

    $getUser = $pdo->query(
      "select userName, points from users"
    );

    ?>
    <html>
      <head>
        <title>Jab 6 Boxing</title>
      </head>
      <body>
        <h1>Jab 6 Boxing</h1>
        <h2>Leaderboard</h2>
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
      </body>
    </html>
    <?php


} else {
  header ('Location: index.php');
}



?>
