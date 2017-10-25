<?php
//Include sessions and sql connection
include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

//autoload classes whenever a new object is created
spl_autoload_register(function($className){
  $className = strtolower($className);
  require __DIR__."/classes/$className.php";
});

date_default_timezone_set('Europe/London');

//if the user session is set store the user in the user variable and the userId in the userId variable
if(isset($_SESSION['user'])){
  $user = unserialize (serialize ($_SESSION['user']));
  $result = $user->getId();
  foreach($result as $i){
    $userId = $i['userId'];
    break;
  }

  //If points post is set
  if(isset($_POST['points'])){

    //Get the users current points
    $r = $pdo->prepare(
      "select points from users
      where userId = :userId"
    );
    $r->execute([
      'userId' => $userId
    ]);

    $points1 = $r->fetch();

    //Add points to users points
    $points = $points1['points'] + $_POST['points'];

    //Update db with users new points total
    $r = $pdo->prepare(
      "update users
      set points = :userPoints
      where userId = :userId"
    );
    $r->execute([
      'userPoints' => $points,
      'userId' => $userId
    ]);

    //Update the points the user got for the current event
    $r = $pdo->prepare(
      "update userPoints
      set points = :userPoints
      where userId = :userId and eventId = 1"
    );
    $r->execute([
      'userPoints' => $_POST['points'],
      'userId' => $userId
    ]);

    //Redirect to leaderboard page
    header("location:leaderboard.php");

  } else {
    //redirect to home page if the points post is not set
    header("location:index.php");
  }

} else {
  //redirect to home page if user is not logged in
  header("location:index.php");
}

?>
