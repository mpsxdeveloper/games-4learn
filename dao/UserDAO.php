<?php

require_once("ConnectionFactory.php");
require_once("../models/User.php");

class UserDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function login(User $user) {

        try {            
            $sql = "SELECT * FROM users WHERE useremail = :useremail";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":useremail", $user->getEmail());
            $rs->execute();
            if($rs->rowCount() > 0) {
                $row = $rs->fetch(PDO::FETCH_OBJ);
                if(password_verify($user->getPassword(), $row->userpassword)) {
                    $user = new User();
                    $user->setId($row->id);                    
                    $user->setName($row->username);
                    return $user;
                }
                else {
                    return null;
                }
            }
        }
        catch(PDOException $e) {
            echo($e->getMessage());
        }
        return null;

    }

    public function save(User $user) {
        try {            
            $sql = "SELECT id FROM users WHERE username = :username OR useremail = :useremail";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":username", $user->getName());
            $rs->bindValue(":useremail", $user->getEmail());
            $rs->execute();
            if($rs->rowCount() > 0) {
                return null;
            }
            else {
                $sql = "INSERT INTO users (username, useremail, userpassword) VALUES (:username, :useremail, :userpassword)";
                $rs = $this->connection->prepare($sql);
                $rs->bindValue(":username", $user->getName());
                $rs->bindValue(":useremail", $user->getEmail());
                $rs->bindValue(":userpassword", $user->getPassword());
                $rs->execute();
                if($rs->rowCount() > 0) {
                    return true;
                }
            }
        }
        catch(PDOException $e) {
            echo($e->getMessage());
        }
        return null;
    }

}