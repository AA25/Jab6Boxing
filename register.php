<?php
//include('classes/user.php');

// spl_autoload_register(function($className){

// })

include('includes/sqlConnect.inc.php');
include('factory/userFactory.php');

echo 'register';
?>

<form method="post" action="../logic/checklogin.php">
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
        <input type="text" name="userName"/>
        <br/>
        <label>password</label>
        <input type="password" name="password"/>
        <br/>
        <label>email</label>
        <input type="text" name="email"/>
        <br/>
        <label>phone</label>
        <input type="text" name="phone"/>
        <br/>
        <input type="submit"/>
</form>
