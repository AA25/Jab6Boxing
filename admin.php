<?php
//Include sessions and sql connection
include('includes/sessions.inc.php');
include('includes/sqlConnect.inc.php');

//autoload classes whenever a new object is created
spl_autoload_register(function($className){
  $className = strtolower($className);
  require __DIR__."/classes/$className.php";
});

//if the user session is set store the user in the user variable
if(isset($_SESSION['login'])){
$user = unserialize (serialize ($_SESSION['user']));
if($user->getType() == 1){
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
      <?php
      //Include the sky betting and gaming product header and the nav bar
      include_once('includes/productHeader.inc.php');
      include_once('includes/navBar.inc.php');
      ?>

      <div class="container" style="color: white;">
      <h1>Admin Page</h1>
      <h4>Enter the matches for an event (Fighter A vs Fighter B)</h4>

      <form method="post" action="logic/addEvent.php" style="color: white;">
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
        <input type="submit"/>

    </div>
  </body>
  <?php
  //include the footer
  include_once('includes/footer.inc.php');
  ?>

    <script src="js/jQuery/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/smoothScroll/smoothScroll.js"></script>
  </html>

  <?php
} else {
  //if user isn't admin redirect to home page
  header ('Location: index.php');
}
} else {
  //If a user isn't logged in redirect to home page
  header ('Location: index.php');
}
?>
