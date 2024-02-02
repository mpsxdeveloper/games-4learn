<?php

require_once("ConnectionFactory.php");
require_once("../models/Prova.php");

class ProvaDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function list($cargo_id) {

        $provas = array();
        try {            
            $sql = "SELECT * FROM provas WHERE cargo_id = :cargo_id";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":cargo_id", $cargo_id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $prova = new Prova();
                    $prova->setId($row->id);
                    $prova->setDescricao($row->descricao);
                    $prova->setAno($row->ano);
                    $prova->setCargo_id($row->cargo_id);
                    array_push($provas, $prova);
                }                
            }
        }
        catch(PDOException $e) {
            echo($e->getMessage());
        }
        return $provas;

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