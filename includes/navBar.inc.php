        <div id="navHeader">
            <div class="container">
                <div class="mart-28 padt-10">
                    <div id="logo" class="disp-in">
                        <h1 class="mar-0">Jab 6 Boxing</h1>
                    </div>
                    <?php if(isset($_SESSION['login'])){ ?>
                        <div id="login"class="disp-in">
                            <a href="logic/logout.php">
                                <i class="fa fa-sign-out fa-1p4x" aria-hidden="true"></i>
                                <span class="fs-18">Logout</span>
                            </a>
                        </div><br><br>
                    <?php }else{ ?>
                        <div id="login" class="disp-in">
                            <form id="loginForm" class="marb-10" name="loginForm" method="post" action="logic/checklogin.php">
                                    <label for="username"><i class="fa fa-user fa-1p4x" aria-hidden="true"></i></label>
                                    <input name="username" type="text" id="username" placeholder="Username">
                                    <label for="password"></label>
                                    <input name="password" type="password" id="password" placeholder="Password">
                                    <input id="submitBtn" type="submit" name="Submit" value="Log In">
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
                        <li><a href="#" target="_blank">Play Jab 6</a></li>
                        <li><a href="#" target="_blank">Results</a></li>
                        <li><a href="#" target="_blank">Leaderboard</a></li>
                        <li><a href="#" target="_blank">Placeholder</a></li>
                        <li><a href="#" target="_blank">How to Play</a></li>
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
                <div class="modal-body">
                    <!-- <form method="post" action="">
                        <label>firstName</label>
                        <input type="text" name="firstName"/>
                        <br/>
                        <label>lastName</label>
                        <input type="text" name="lastName"/>
                        <br/>
                        <label>dob</label>
                        <input type="text" name="dob"/>
                        <br/>
                        <label>username</label>
                        <input type="text" name="firstName"/>
                        <br/>
                        <label>password</label>
                        <input type="text" name="firstName"/>
                        <br/>
                        <label>email</label>
                        <input type="text" name="email"/>
                        <br/>
                        <label>phone</label>
                        <input type="text" name="phone"/>
                        <br/>
                        <input type="submit"/>
                    </form> -->
                </div>
                <div class="modal-footer bord-rd-bl bord-rd-br">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            
            </div>
        </div>