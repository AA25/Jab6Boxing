        <div id="navHeader">
            <div class="container">
                <div class="mart-28 padt-10">
                    <div id="logoDiv" class="disp-in">
                        <!-- <h1 class="mar-0">Jab 6 Boxing</h1> -->
                        <a href="./index.php"><img src="/images/realLogo.png" alt="logo"></a>
                    </div>
                    <?php if(isset($_SESSION['login'])){ ?>
                        <div id="login"class="disp-in">
                            <span id="welcomeMsg" class="fs-18"></span>
                            <br>
                            <a href="logic/logout.php">
                                <i class="fa fa-sign-out fa-1p4x" aria-hidden="true"></i>
                                <span class="fs-18">Logout</span>
                            </a>
                        </div><br><br>
                    <?php }else{ ?>
                        <div id="login" class="disp-in">
                            <form id="loginForm" class="marb-10" name="loginForm" method="post" action="logic/checklogin.php">
                                <label for="username"><i class="fa fa-user fa-1p4x" aria-hidden="true"></i></label>
                                <input name="userName" type="text" id="username" placeholder="Username">
                                <label for="password"></label>
                                <input name="password" type="password" id="password" placeholder="Password">
                                <input id="loginBtn" type="submit" name="Submit" value="Log In">
                            </form>
                            <div id="register">
                                <!-- <button type="button" id="registerBtn" class="btn btn-link" data-toggle="modal" data-target="#registerModal">
                                    <i class="fa fa-user-plus fa-1p4x" aria-hidden="true"></i>
                                    <span class="fs-14">Register</span>
                                </button> -->
                                <a id="registerBtn" href="#" data-toggle="modal" data-target="#registerModal">
                                    <i class="fa fa-user-plus fa-1p4x" aria-hidden="true"></i>
                                    <span class="fs-14">Register</span>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
                <div class="disp-block">
                    <ul id="navList" class="list-inline">
                        <li><a href="./index.php">Home</a></li>
                        <li><a href="./prediction.php">Predictions</a></li>
                        <li><a href="./checkResults.php">Results</a></li>
                        <li><a href="./leaderboard.php">Leaderboard</a></li>
                        <li><a href="./howToPlay.php">How to Play</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="registerModal" role="dialog">
            <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header cl-white bg-jab6 bord-rd-tl bord-rd-tr">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">REGISTRATION DETAILS</h4>
                </div>
                <div class="modal-body bord-rd-bl bord-rd-br">
                    <form method="post" action="logic/checklogin.php" id="registerForm" class="marb-0">
                        <div class="form-group">
                            <label for="firstName">First Name:</label>
                            <input type="text" class="form-control" placeholder="Enter first name" name="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name:</label>
                            <input type="text" class="form-control" placeholder="Enter last name" name="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Date of Birth:</label>
                            <input type="text" class="form-control" placeholder="Enter D.O.B" name="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Username</label>
                            <input type="text" class="form-control" placeholder="Enter username" name="userName" required>
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" placeholder="Enter password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" class="form-control" placeholder="Enter email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="phone" class="form-control" placeholder="Enter phone number" name="phone" required>
                        </div>
                        <button type="submit" class="jab6Btn fs-16" style="margin-left:87%">Register</button>
                    </form>
                </div>
                <!-- <div class="modal-footer bord-rd-bl bord-rd-br">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div> -->
            </div>

            </div>
        </div>
