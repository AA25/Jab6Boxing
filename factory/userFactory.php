<?php

    class userFactory{
        private $db;
        
            public function __construct(PDO $db){
                $this->db = $db; 
            }

            public function insert(User $user){
                $stmt = $this->db->prepare("
                    insert into users (firstName, lastName, dob, userName, password, email, phone, type, points)
                    values (:firstName, :lastName, :dob, :username, :password, :email, :phone, :type, :points)
                ");

                $results = $stmt->execute([
                    'firstNme'  => $user->firstName,
                    'lastName'  => $user->lastName,
                    'dob'  => $user->dob,
                    'userName'  => $user->userName,
                    'password'  => $user->password,
                    'email'  => $user->email,
                    'phone' => $user->phone,
                    'type' => 0,
                    'points' => 0 
                ]);
            }
            //$user->id = $this->db->lastInsertId();
    }

?>