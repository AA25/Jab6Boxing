<?php
// check login and create SESSION and count attempts
include('../includes/sessions.inc.php');
if($_POST['username'] == "admin" && $_POST['password'] == "letmein"){
  $_SESSION['login'] = 1;
  $_SESSION['username'] = $_POST['username'];
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
