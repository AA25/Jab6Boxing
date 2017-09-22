<?php
include('../includes/sqlConnect.inc.php');


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

$realNoEvents = $pdo->lastInsertId();

$r = $pdo->prepare(
  "insert into
  boxingMatches (eventId, matchName)
  values (:eventId, :matchName)"
);
$r->execute([
  'matchName' => $_POST['M1'],
  'eventId' => $realNoEvents
]);
$r->execute([
  'matchName' => $_POST['M2'],
  'eventId' => $realNoEvents
]);
$r->execute([
  'matchName' => $_POST['M3'],
  'eventId' => $realNoEvents
]);
$r->execute([
  'matchName' => $_POST['M4'],
  'eventId' => $realNoEvents
]);
$r->execute([
  'matchName' => $_POST['M5'],
  'eventId' => $realNoEvents
]);
$r->execute([
  'matchName' => $_POST['M6'],
  'eventId' => $realNoEvents
]);

?>
