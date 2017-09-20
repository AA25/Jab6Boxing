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

        function getMe(){
            return $this->firstName;
        }


    }
?>
