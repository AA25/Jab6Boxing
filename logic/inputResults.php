<?php
include('../includes/sqlConnect.inc.php');

$r = $pdo->prepare(
  "update boxingMatches
  set result = :result, round = :round, duration = :duration
  where individualMatchId = :matchId and eventId = :eventId"
);
$r->execute([
  'result' => 'alex',
  'round' => 12,
  'duration' => 1200,
  'matchId' => 1,
  'eventId' => 2
]);
$r->execute([
  'result' => 'someoneElse',
  'round' => 12,
  'duration' => 1200,
  'matchId' => 2,
  'eventId' => 2

]);
$r->execute([
  'result' => 'Other Person',
  'round' => 12,
  'duration' => 1200,
  'matchId' => 3,
  'eventId' => 2
]);
$r->execute([
  'result' => 'Unknown',
  'round' => 12,
  'duration' => 1200,
  'matchId' => 4,
  'eventId' => 2
]);
$r->execute([
  'result' => 'Larry',
  'round' => 12,
  'duration' => 1200,
  'matchId' => 5,
  'eventId' => 2
]);
$r->execute([
  'result' => 'zdgfhdyj',
  'round' => 12,
  'duration' => 1200,
  'matchId' => 6,
  'eventId' => 2
]);

?>
