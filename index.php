<?php
    include_once('includes/sessions.inc.php');
    include('includes/sqlConnect.inc.php');

    spl_autoload_register(function($className){
        $className = strtolower($className);
        require __DIR__."/classes/$className.php";
      });
      
    date_default_timezone_set('Europe/London');
?>

<html>
    <head>
        <title>Jab 6 Boxing</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome-4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/jab6style.css"/>
        <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    </head>
    <body id="top">
        <?php   include_once('includes/productHeader.inc.php');
                include_once('includes/navBar.inc.php'); 
        ?>
        <div class="contentBanner ">
            <div class="container">
                
                <div class="row center txt-ctr" style="margin-top:19%">
                    <p class="padt-10 padb-10 marb-0 bord-rd" style="background:none;">
                        <!-- £250,000 <br> -->
                        <a href="prediction.php" id="playBtn" class="btn bord-rd fs-18" role="button">Play For Free Now</a>
                    </p>
                    <p class="marb-0 cl-white fs-11">
                        *Minimum prize value dependent on exchange rate applied to £ equivalent
                    </p>
                </div>

            </div>
        </div>
    </body>
    
    <?php   include_once('includes/footer.inc.php');?>

    <script src="js/jQuery/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/smoothScroll/smoothScroll.js"></script>
</html>
