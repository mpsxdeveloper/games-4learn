<?php

    session_start();
    header("Content-Type: application/json; charset=utf-8");
    
    require_once("../dao/UserDAO.php");
    require_once("../models/User.php");

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
    if($query == "login") {        
        $email = filter_input(INPUT_POST, trim("email"));
        $password = filter_input(INPUT_POST, "password");
        $csrf = filter_input(INPUT_POST, "csrf");
        $userDAO = new UserDAO();
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);
        $usuario = $userDAO->login($user);
        if($usuario !== null && $csrf == $_SESSION["csrf"]) {            
            $_SESSION["id"] = $usuario->getId();
            $_SESSION["nome"] = $usuario->getName();
            echo json_encode($usuario);
        }    
        else {
            echo json_encode(null);            
        }
    }
    if($query == "logout") {        
        $_SESSION["id"] = null;
        $_SESSION["nome"] = null;
        echo json_encode(null);       
    }
