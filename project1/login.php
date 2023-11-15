<?php

try {
    
    require_once './models/utilities.php';
    require_once './models/database.php';
    require_once './models/login.php';

    $email_address = htmlspecialchars(filter_input(INPUT_POST, "email_address"));
    $password = filter_input(INPUT_POST, "password");
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $action = htmlspecialchars(filter_input(INPUT_GET, "action"));
    $message = "";
    
    if($action == "logout") {
        $_SESSION = array();
        session_destroy();
        header('Location: index.php');
        exit();
    }
    
    if($email_address != "" && $password != "") {
        if(login($email_address, $password)) {
            $_SESSION['is_logged_in'] = true;
            header('Location: index.php');
            exit();
        } else {
            $message = "login failed";
        }
    }
        
    include('views/login.php');
} catch (Exception $e) {
    $error_message = $e->getMessage();
    include('./views/error.php');
}
?>

