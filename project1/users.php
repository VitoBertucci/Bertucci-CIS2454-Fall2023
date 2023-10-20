<?php

try {
    
    require_once './models/database.php';
    require_once './models/users.php';
    require_once './models/utilities.php';
    
    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));
    $user_id = filter_input(INPUT_POST, "user_id");
    $email_address = htmlspecialchars(filter_input(INPUT_POST, "email_address"));
    $name_user = htmlspecialchars(filter_input(INPUT_POST, "name_user"));
    $cash_balance = filter_input(INPUT_POST, "cash_balance");
    
    //display tables
    $users = display_users();
    include ('views/users.php');
    
    switch ($action) {
        case "insert_user":
            insert_user($name_user, $email_address, $cash_balance);
            header("Location: users.php");
            break;
        case "update_user":
            update_user($user_id, $name_user, $email_address, $cash_balance);
            header("Location: users.php");
            break;
        case "delete_user":
            delete_user($user_id);
            header("Location: users.php");
            break;
    }
    
} catch (Exception $e) {
    $error_message = $e->getMessage();
    include('./views/error.php');
}
?>