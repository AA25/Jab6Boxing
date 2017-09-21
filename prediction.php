<?php
include('includes/sessions.inc.php');
if(isset($_SESSION['login'])){
  echo "Your logged in!";
} else {
  header ('Location: index.php');
}
 ?>
