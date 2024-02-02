<?php

require_once("ConnectionFactory.php");

class MateriaDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function list($prova_id) {

        $provas = array();
        try {            
            $sql = "SELECT *, a.id AS materiaID, a.materia FROM provas p
            INNER JOIN questoes q            
            ON q.prova_id = :prova_id
            INNER JOIN assuntos a
            ON a.id = q.assunto_id
            GROUP BY q.assunto_id";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":prova_id", $prova_id);            
            $rs->execute();
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $prova = new stdClass();
                    $prova->id = $row->id;
                    $prova->descricao = $row->descricao;
                    $prova->ano = $row->ano;
                    $prova->materiaID = $row->materiaID;
                    $prova->materia = $row->materia;
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