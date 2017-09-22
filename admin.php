<?php
include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

spl_autoload_register(function($className){
  $className = strtolower($className);
  require __DIR__."/classes/$className.php";
});

if(isset($_SESSION['login'])){
  $user = unserialize (serialize ($_SESSION['user']));
  if($user->getType() == 1){
    echo "User is admin";
  } else {
    header ('Location: index.php');
  }
} else {
  header ('Location: index.php');
}

?>
