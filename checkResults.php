<?php


date_default_timezone_set('Europe/London');

$recoveredBets = file_get_contents('bets.txt');
$bets = unserialize($recoveredBets);

$prediction = $bets;

$recoveredData = file_get_contents('results.txt');
$results = unserialize($recoveredData);


//print_r($results);
//echo date('Y/m/d h:i:sa' ,$timeOfBet);

//if the predications match the results
$points = array();
for($outer = 1; $outer < count($prediction) - 1; $outer++ ){
    $option1 = 0; $option2 = 0;
    for($inner = 0; $inner < count($prediction[$outer]); $inner++) {
      //echo $prediction[$outer][$inner] . "<br>";
      //echo $results[$outer][$inner]. "<br>";
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

if(($points[0] + $points[1] + $points[2]) == 15){
  echo $prediction[0] . " you scored won the jackpot!!!!!";
} else {
  echo $prediction[0] . " you scored " . ($points[0] + $points[1] + $points[2]) . " points!";
}
?>
<br/>
<a href="index.php">Home</a>
