<?php

require_once("ConnectionFactory.php");
require_once("../models/Questao.php");

class QuestaoDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function list($prova_id, $assunto_id) {

        $questoes = array();
        try {            
            $sql = "SELECT * FROM questoes WHERE prova_id = :prova_id AND assunto_id = :assunto_id";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":prova_id", $prova_id);
            $rs->bindValue(":assunto_id", $assunto_id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $questao = new Questao();
                    $questao->setId($row->id);
                    $questao->setPergunta($row->pergunta);
                    $questao->setResposta1($row->resposta1);
                    $questao->setResposta2($row->resposta2);
                    $questao->setResposta3($row->resposta3);
                    $questao->setResposta4($row->resposta4);
                    $questao->setResposta5($row->resposta5);
                    $questao->setGabarito($row->gabarito);
                    $questao->setProva_id($row->prova_id);
                    array_push($questoes, $questao);
                }                
            }
        }
        catch(PDOException $e) {
            echo($e->getMessage());
        }
        return $questoes;

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