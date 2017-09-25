<?php


date_default_timezone_set('Europe/London');

$recoveredBets = file_get_contents('bets.txt');
$bets = unserialize($recoveredBets);

$prediction = $bets;

$recoveredData = file_get_contents('results.txt');
$results = unserialize($recoveredData);

$points = array();
for($outer = 1; $outer < count($prediction) - 1; $outer++ ){
    $option1 = 0; $option2 = 0;
    for($inner = 0; $inner < count($prediction[$outer]); $inner++) {
      if($prediction[$outer][$inner] == $results[$outer-1][$inner]){
        $option1++;
      }
      if($prediction[$outer][$inner+1] == $results[$outer-1][$inner+1]){
        $option2++;
      }
      $inner++;
    }
    if ($option1 == 1 && $option2 == 1){
      array_push($points, 5);
    }
    elseif($option1 == 1 && $option2 == 0){
      array_push($points, 2);
    }
    else{
      array_push($points, 0);
    }
  }

if(($points[0] + $points[1] + $points[2]) == 30){
  echo $prediction[0] . " you have won the Jab6 jackpot!!!";
} else {
  echo $prediction[0] . " you scored " . ($points[0] + $points[1] + $points[2]) . " points!";
}
?>

<br>
<a href="index.php">Home</a>
