<?php

require_once './models/utilities.php';

function login($email_address, $password) {
    global $database;

    $query = 'SELECT email_address, password_hash FROM users WHERE email_address = :email_address';
    
    $user = execute_query($database, $query, [':email_address' => $email_address])->fetch();
    
    if ($user == NULL) {
        return false;
    }

    return password_verify($password, $user['password_hash']);
}
?>

