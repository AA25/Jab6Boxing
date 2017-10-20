<?php

include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

spl_autoload_register(function($className){
  $className = strtolower($className);
  require __DIR__."/classes/$className.php";
});

date_default_timezone_set('Europe/London');

if(isset($_SESSION['user'])){
  $user = unserialize (serialize ($_SESSION['user']));
  $result = $user->getId();
  foreach($result as $i){
    $userId = $i['userId'];
    break;
  }

  if(isset($_POST['points'])){

    $r = $pdo->prepare(
      "select points from users
      where userId = :userId"
    );
    $r->execute([
      'userId' => $userId
    ]);

    $points1 = $r->fetch();
    $points = $points1['points'] + $_POST['points'];

    $r = $pdo->prepare(
      "update users
      set points = :userPoints
      where userId = :userId"
    );
    $r->execute([
      'userPoints' => $points,
      'userId' => $userId
    ]);

    $r = $pdo->prepare(
      "update userPoints
      set points = :userPoints
      where userId = :userId and eventId = 1"
    );
    $r->execute([
      'userPoints' => $_POST['points'],
      'userId' => $userId
    ]);

    header("location:leaderboard.php");

  } else {
    header("location:index.php");
  }

} else {
  header("location:index.php");
}

?>
