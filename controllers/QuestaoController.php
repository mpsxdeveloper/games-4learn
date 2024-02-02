<?php

    session_start();
    header("Content-Type: application/json; charset=utf-8");
    
    require_once("../dao/QuestaoDAO.php");
    require_once("../models/Questao.php");

    $query = filter_input(INPUT_POST, "query");
    
    if($query == "list") {
        $prova_id = filter_input(INPUT_POST, "prova_id");
        $assunto_id = filter_input(INPUT_POST, "assunto_id");
        $questaoDAO = new QuestaoDAO();
        echo json_encode($questaoDAO->list($prova_id, $assunto_id));
    }
