<?php

    session_start();
    header("Content-Type: application/json; charset=utf-8");
    
    require_once("../dao/CargoDAO.php");
    require_once("../models/Cargo.php");

    $query = filter_input(INPUT_POST, "query");
    
    if($query == "register") {
        $name = filter_input(INPUT_POST, trim("name"));
        $email = filter_input(INPUT_POST, trim("email"));
        $password = filter_input(INPUT_POST, "password");
        $userDAO = new UserDAO();
        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        echo json_encode($userDAO->save($user));
    }
    if($query == "list") {        
        $cargoDAO = new CargoDAO();
        echo json_encode($cargoDAO->list());
    }
