<?php

$host = '127.0.0.1';
$db = 'jab6';
$user = 'jab6user';
$pass = 'The password';

$dsn = "mysql:host=$host;dbname=$db";
$pdo = new PDO($dsn, $user, $pass);

?>