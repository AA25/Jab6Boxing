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
                    'firstName'  => $user->firstName,
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

            function getUserFromId($id){
                $getUser = $this->db->prepare(
                  "select firstName, lastName, dob, userName, password, email, phone, type, points from users where userId = :userId"
                );
                $getUser->execute(['userId' => $id]);
                foreach ($getUser as $userInfo) {
                  $user = new User($userInfo['firstName'], $userInfo['lastName'], $userInfo['dob'], $userInfo['userName'], $userInfo['password'], $userInfo['email'], $userInfo['phone'], $userInfo['type'], $userInfo['points']);
                  return $user;
                }
                return null;
            }
    }

?>
