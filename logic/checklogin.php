<?php
// check login and create SESSION and count attempts
include('../includes/sessions.inc.php');
include('../includes/sqlConnect.inc.php');

//Auto loads all the classes needed
spl_autoload_register(function($class){
    $class = strtolower($class);
    require __DIR__."/../classes/$class.php";
});

//Check to see if firstName was posted here in which the register form was filled and we register the user
if(isset($_POST['firstName'])){
  //Hash the password
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

  //Once registered we set the login session to true
  $_SESSION['login'] = 1;
  $_SESSION['userName'] = $_POST['userName'];

  $thisUser = new User($_POST['firstName'], $_POST['lastName'], $_POST['dob'], $_POST['userName'], $_POST['password'], $_POST['email'], $_POST['phone'], 1, 0);

  //Create a session var containing the user class of this user
  $_SESSION['user'] = $thisUser;
  echo 'registered';
  //header('Location: ../index.php');

} elseif(isset($_POST['userName'])) { //If userName was posted then we know the login form was filled 
  $status = '';
  
  //Check if the user details are valid
  $r = $pdo->prepare(
    "select userId, userName, password from users where userName = :userName"
  );
  $r->execute(['userName' => $_POST['userName']]);
  foreach ($r as $userInfo) {
    $userFactory = new userFactory($pdo);
    $thisUser = $userFactory->getUserFromId($userInfo['userId']);
    if($_POST['userName'] == $userInfo['userName'] && $thisUser->passwordValid($_POST['password'])){
      //if valid then set these sessions
      $_SESSION['login'] = 1;
      $_SESSION['userName'] = $_POST['userName'];
      $_SESSION['user'] = $thisUser;
      $_SESSION['currentEvent'] = 1;
      $status = 'correct';
      echo $status;
      //header('Location: ../index.php');
    }
  }
  //If status is empty then the login detail was wrong
  if(strcmp($status,'') == 0){
    echo 'wrong';
  }
  
}
?>