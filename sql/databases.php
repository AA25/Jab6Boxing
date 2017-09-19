<?php

include('includes/sessions.inc.php');

$predRound = 6;

$r = $pdo->prepare( // use query instead of prepare whan there is no variable being inserted
  "select predictedResult from userMatchPredictions where predictedRound = :predictedRound"
);
$r->execute(['predictedRound' => $predRound]);

foreach ($r as $row) {
  echo $row["predictedResult"] . PHP_EOL;
}

$r = $pdo->query(
  "select * from boxingMatches"
);

foreach ($r as $row) {
  var_dump($row);
}


$r = $pdo->query(
  "select users.firstName, userMatchPredictions.predictedResult, boxingMatches.matchName from userPrediction join users on users.userId = userPrediction.userId join userMatchPredictions on userMatchPredictions.predictionId = userPrediction.predictionId join boxingMatches on boxingMatches.matchId = userMatchPredictions.matchId where users.userId = 1 and boxingMatches.matchId=3;"
);

foreach ($r as $row) {
  echo $row["firstName"] . "'s prediction for " . $row["matchName"] . " is " . $row["predictedResult"] . PHP_EOL;
}


?>
