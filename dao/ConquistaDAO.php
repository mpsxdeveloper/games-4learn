<?php

require_once("ConnectionFactory.php");
require_once("../models/Conquista.php");

class ConquistaDAO {

    private $connection;
    
    public function __construct() {
        $this->connection = ConnectionFactory::connect();
    }

    public function list($usuario_id) {

        $conquistas = array();
        try {            
            $sql = "SELECT c.prova_id, p.descricao AS provadesc, p.ano
            FROM conquistas c 
            INNER JOIN provas p ON p.id = c.prova_id                
            WHERE c.usuario_id = :usuario_id";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":usuario_id", $usuario_id);
            $rs->execute();
            if($rs->rowCount() > 0) {
                while($row = $rs->fetch(PDO::FETCH_OBJ)) {
                    $stdClass = new stdClass();
                    $stdClass->descricao = $row->provadesc;
                    $stdClass->ano = $row->ano;    
                    array_push($conquistas, $stdClass);
                }
            }
        }
        catch(PDOException $e) {
            echo($e->getMessage());
        }
        return $conquistas;

    }

    public function save(Conquista $conquista) {
        try {            
            $sql = "SELECT id FROM conquistas WHERE usuario_id = :usuario_id AND prova_id = :prova_id";
            $rs = $this->connection->prepare($sql);
            $rs->bindValue(":usuario_id", $conquista->getUsuario_id());
            $rs->bindValue(":prova_id", $conquista->getProva_id());
            $rs->execute();
            if($rs->rowCount() > 0) {
                
            }
            else {
                $sql = "INSERT INTO conquistas (prova_id, usuario_id) VALUES (:prova_id, :usuario_id)";
                $rs = $this->connection->prepare($sql);
                $rs->bindValue(":prova_id", $conquista->getProva_id());
                $rs->bindValue(":usuario_id", $conquista->getUsuario_id());
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