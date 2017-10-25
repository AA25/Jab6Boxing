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

} else {
  header ('Location: index.php');
}
} else {
header ('Location: index.php');
}
?>


<html>
<head>
    <title>Admin</title>
    <title>Jab 6 Boxing</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/jab6style.css"/>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
</head>

<body id="top">
    <?php   include_once('includes/productHeader.inc.php');
            include_once('includes/navBar.inc.php'); 
    ?>

    <div class="container" style="color: white;">
    <h1>Admin Page</h1>
    <h4>Enter the matches (Fighter A vs Fighter B)</h4>

    <form method="post" action="logic/addEvent.php">
          <?php
for($i=1; $i<=6; $i++){
  ?>
<label>Match <?php echo $i ?> - Match Name</label>
  <input type="text" name="M<?php echo $i ?>"/>
  <br/>
  <?php
}
           ?>
          <br>
          <h4>Create an event (YYYY-MM-DD HH:MM:SS)</h4>
          <label>Start Date/Time</label>
          <input type="text" name="startTime"/>
          <label>End Date/Time</label>
          <input type="text" name="endTime"/>
          <input type="submit" style="color: black;"/>

          <a href="logic/inputResults.php">Submit results</a>

    </body>
</html>


