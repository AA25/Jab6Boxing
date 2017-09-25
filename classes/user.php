<?php

    class User {
        private $firstName;
        private $lastName;
        private $dob;
        private $username;
        private $password;
        private $email;
        private $phone;
        private $type;
        private $points;

        function __construct($firstName,$lastName,$dob,$username,$password,$email,$phone,$type){
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->dob = $dob;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->phone = $phone;
            $this->type = $type;
            $this->points = 0;
        }

        function getFirstName(){
            return $this->firstName;
        }

        function getLastName(){
            return $this->lastName;
        }

        function getDoB(){
            return $this->dob;
        }

        function getUserName(){
            return $this->username;
        }

        function getPassword(){
            return $this->password;
        }

        function getEmail(){
            return $this->email;
        }

        function getPhone(){
            return $this->phone;
        }

        function getType(){
            return $this->type;
        }

        function getPoints(){
            return $this->points;
        }

        function setFirstName($firstName){
            $this->firstName = $firstName;
        }

        function setLastName($lastName){
            $this->lastName = $lastName;
        }

        function setDoB($dob){
            $this->dob = $dob;
        }

        function setUsername($username){
            $this->username = $username;
        }

        function setPassword($password){
            $this->password = $password;
        }

        function setEmail($email){
            $this->email = $email;
        }

        function setPhone($phone){
            $this->phone = $phone;
        }

        function setType($type){
            $this->type = $type;
        }

        function setPoints($points){
            $this->points = $points;
        }

        function getId(){
            include('./includes/sqlConnect.inc.php');
            
            $r = $pdo->prepare(
                "select userId from users where userName = :userName"
            );
            $r->execute(['userName' => $this->username]);
            return $r;
        }
        public function passwordValid($pass){
            return password_verify($pass, $this->password);
        }

    }
?>
