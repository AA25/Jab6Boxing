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

        public function passwordValid($pass){
            return password_verify($pass, $this->password);
        }

    }
?>
