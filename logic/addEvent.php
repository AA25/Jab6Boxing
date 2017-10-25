<?php
include('../includes/sqlConnect.inc.php');

//insert events into db
$r = $pdo->prepare(
  "insert into
  event (startTime, endTime)
  values (:startTime, :endTime)"
);
$worked = $r->execute([
  'startTime' => $_POST['startTime'],
  'endTime' => $_POST['endTIme']
]);

if(!$worked){
  echo "Not worked";
  exit();
}

//The id of the last event added 
$realNoEvents = $pdo->lastInsertId();

//Insert boxing matches for the last event
$r = $pdo->prepare(
  "insert into
  boxingMatches (eventId, individualMatchId, matchName)
  values (:eventId, :individualMatchId, :matchName)"
);
$worked = $r->execute([
  'matchName' => $_POST['M1'],
  'eventId' => $realNoEvents,
  'individualMatchId' => 1
]);
if(!$worked){
  echo "Not worked1";
  exit();
}
$worked = $r->execute([
  'matchName' => $_POST['M2'],
  'eventId' => $realNoEvents,
  'individualMatchId' => 2
]);
if(!$worked){
  echo "Not worked2";
  exit();
}
$worked = $r->execute([
  'matchName' => $_POST['M3'],
  'eventId' => $realNoEvents,
  'individualMatchId' => 3
]);
if(!$worked){
  echo "Not worked3";
  exit();
}
$worked = $r->execute([
  'matchName' => $_POST['M4'],
  'eventId' => $realNoEvents,
  'individualMatchId' => 4
]);
if(!$worked){
  echo "Not worked4";
  exit();
}
$worked = $r->execute([
  'matchName' => $_POST['M5'],
  'eventId' => $realNoEvents,
  'individualMatchId' => 5
]);
if(!$worked){
  echo "Not worked5";
  exit();
}
$worked = $r->execute([
  'matchName' => $_POST['M6'],
  'eventId' => $realNoEvents,
  'individualMatchId' => 6
]);
if(!$worked){
  echo "Not worked6";
  exit();
}

?>
