<?php
include('includes/sessions.inc.php');

date_default_timezone_set('Europe/London');
$timeOfBet = time();
$recoveredBetBy = file_get_contents('betBy.txt');
$betByTime = unserialize($recoveredBetBy);

$recoveredBets = file_get_contents('bets.txt');
$bets = unserialize($recoveredBets);

if($timeOfBet < $betByTime){

  echo "Your bet has been saved!";
  ?>
  <p>Click <a href="checkResults.php">here</a> to check the results</p>
  <?php

  $prediction = array(
    $_SESSION['username'],
    array($_POST['match1'], $_POST['match1Round']),
    array($_POST['match2'], $_POST['match2Round']),
    array($_POST['match3'], $_POST['match3Round']),
    $_POST['goldenGlove']
  );

  array_push($bets, $prediction);

  $betsSerialize = serialize($prediction);
  // save serialized data in a text file
  file_put_contents('bets.txt', $betsSerialize);

} else {

  echo "You can't bet";

}

?>
