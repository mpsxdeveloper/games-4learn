<?php

require_once("ConnectionFactory.php");
require_once("../models/Cargo.php");

class CargoDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function list() {

        $cargos = array();
        try {            
            $sql = "SELECT * FROM cargos";
            $rs = $this->connection->prepare($sql);            
            $rs->execute();
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $cargo = new Cargo();
                    $cargo->setId($row->id);
                    $cargo->setDescricao($row->descricao);
                    array_push($cargos, $cargo);
                }
            }
        }
        catch(PDOException $e) {
            echo($e->getMessage());
        }
        return $cargos;

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
