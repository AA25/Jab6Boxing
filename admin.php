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
    ?>
    <html>
    <head>
      <title>Admin</title>
      </head>
      <body>
        <h1>Admin Page</h1>
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
          <label>Start Time</label>
          <input type="text" name="startTime"/>
          <label>End Time</label>
          <input type="text" name="endTime"/>
          <input type="submit"/>
</body>
      </html>
      <?php
  } else {
    header ('Location: index.php');
  }
} else {
  header ('Location: index.php');
}


?>
