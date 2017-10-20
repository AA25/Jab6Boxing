<?php
// check login and create SESSION and count attempts
include('../includes/sessions.inc.php');
include('../includes/sqlConnect.inc.php');

spl_autoload_register(function($class){
    $class = strtolower($class);
    require __DIR__."/../classes/$class.php";
});

if(isset($_POST['firstName'])){
  //register
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $r = $pdo->prepare(
    "insert into
    users (firstName, lastName, dob, userName, password, email, phone, type, points)
    values(:firstName, :lastName, :dob, :userName, :password, :email, :phone, :type, :points);"
  );
  $r->execute([
    'firstName' => $_POST['firstName'],
    'lastName' => $_POST['lastName'],
    'dob' => $_POST['dob'],
    'userName' => $_POST['userName'],
    'password' => $password,
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'type' => 1,
    'points' => 0
  ]);

  $_SESSION['login'] = 1;
  $_SESSION['userName'] = $_POST['userName'];

  $thisUser = new User($_POST['firstName'], $_POST['lastName'], $_POST['dob'], $_POST['userName'], $_POST['password'], $_POST['email'], $_POST['phone'], 1, 0);

  $_SESSION['user'] = $thisUser;
  echo 'registered';
  //header('Location: ../index.php');

} elseif(isset($_POST['userName'])) {
  $status = '';
  //login
  $r = $pdo->prepare(
    "select userId, userName, password from users where userName = :userName"
  );
  $r->execute(['userName' => $_POST['userName']]);
  foreach ($r as $userInfo) {
    $userFactory = new userFactory($pdo);
    $thisUser = $userFactory->getUserFromId($userInfo['userId']);
    if($_POST['userName'] == $userInfo['userName'] && $thisUser->passwordValid($_POST['password'])){
      $_SESSION['login'] = 1;
      $_SESSION['userName'] = $_POST['userName'];
      $_SESSION['user'] = $thisUser;
      $_SESSION['currentEvent'] = 1;
      $status = 'correct';
      echo $status;
      //header('Location: ../index.php');
    }
  }
  if(strcmp($status,'') == 0){
    echo 'wrong';
  }
  
}
?>