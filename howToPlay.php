<?php
include('includes/sessions.inc.php');
 ?>
<html>
<head>
  <title>How To Play</title>
</head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome-4.7.0/css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="css/jab6style.css"/>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<body id="top">
<?php   include_once('includes/productHeader.inc.php');
        include_once('includes/navBar.inc.php');
?>
<div class = "container">
<h1>Game Rules:</h1>
<h2>General:</h2>
<p>6 boxing matches are selected for a round of the game by Sky Betting & Gaming.
Each player must predict the boxer they believe will win the fight and in which round, for example: Mayweather - Round 8, for the chosen 6 boxing matches. Points can also be chosen as an option here.
A player must submit their predictions prior to the beginning of the first boxing match chosen for a given round of matches.</p>

<h2>Scoring:</h2>
<p>The scoring for the game works as follows:
2 points for a correct result (without the correct round), e.g. Mayweather wins on points when the player has predicted Mayweather to win in Round 8.
5 points for a correct prediction, e.g. Mayweather wins in Round 8 when the player has predicted Mayweather to win in Round 8.</p>

<h2>Tiebreaker (‘Golden Glove’)</h2>
<p>Each player must predict which boxer will finish their match in the earliest time, to provide a tiebreaker if required. This is the same as ‘Golden Goal’ in Super6.</p>

<h2>The Jackpot Prize (‘The Knockout’) (£250,000)</h2>
<p>The jackpot prize is awarded to a player if the result (including round) of all 6 boxing matches are predicted correctly, i.e. the player scores 30 points.
If there are multiple players with 6 correct predictions the tiebreaker will be used to determine the overall winner (see Tiebreaker).
If the tiebreaker fails to determine an overall winner, the jackpot prize will be given to the player with the earliest submission of predictions.</p>

<h2>The Consolation Prize (£5,000)</h2>
<p>In the event the jackpot prize is not won in a given round of boxing matches, the standard prize will be awarded to the player with the highest points total.
Again, If there are multiple players with the same score the tiebreaker will be used to determine the overall winner (see Tiebreaker).
If the tiebreaker fails to determine an overall winner, the standard prize will be shared equally between the players.</p>
</div>
</body>
  <?php   include_once('includes/footer.inc.php');?>
</html>
