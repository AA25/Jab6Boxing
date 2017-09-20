<?php
// check login and create SESSION and count attempts
include('../includes/sessions.inc.php');
include('../includes/sqlConnect.inc.php');

if(isset($_POST['firstName'])){

  //register
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
    'password' => $_POST['password'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'type' => 1,
    'points' => 0
  ]);

  $_SESSION['login'] = 1;
  $_SESSION['userName'] = $_POST['userName'];

  header('Location: ../index.php');

}

//login
$r = $pdo->prepare(
  "select userName, password from users where userName = :userName"
);
$r->execute(['userName' => $_POST['userName']]);

foreach ($r as $userInfo) {
  if($_POST['userName'] == $userInfo['userName'] && $_POST['password'] == $userInfo['password']){
    $_SESSION['login'] = 1;
    $_SESSION['userName'] = $_POST['userName'];
  } else {
    echo "Wrong username or password";
  }
}

header('Location: ../index.php');
?>
