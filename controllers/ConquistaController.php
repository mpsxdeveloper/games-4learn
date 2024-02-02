<?php

    session_start();
    header("Content-Type: application/json; charset=utf-8");
    
    require_once("../dao/ConquistaDAO.php");
    require_once("../models/Conquista.php");

    $query = filter_input(INPUT_POST, "query");
    
    if($query == "register") {
        $prova_id = filter_input(INPUT_POST, "prova_id");
        $usuario_id = $_SESSION["id"];
        $conquistaDAO = new ConquistaDAO();
        $conquista = new Conquista();
        $conquista->setUsuario_id($usuario_id);
        $conquista->setProva_id($prova_id);
        echo json_encode($conquistaDAO->save($conquista));
    }
    if($query == "list") {
        $conquistaDAO = new ConquistaDAO();
        echo json_encode($conquistaDAO->list($_SESSION["id"]));
    }
