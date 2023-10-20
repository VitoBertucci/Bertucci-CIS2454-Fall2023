<?php
    require_once './models/utilities.php';
    
    //display users
    function display_users() {
        global $database;
        
        $query = 'SELECT name, email_address, cash_balance, id FROM users';
        return execute_query($database, $query);
    }
    
    //insert user
    function insert_user($name_user, $email_address, $cash_balance) {
        global $database;
        
        //check form inputs
        if ($name_user !== '' && $email_address !== '' && $cash_balance !== false) {
            //insert user
            $query = 'INSERT INTO users (name, email_address, cash_balance) VALUES (:name_user, :email_address, :cash_balance)';
            $inserted = execute_query($database, $query, [
                ':name_user' => htmlspecialchars($name_user),
                ':email_address' => htmlspecialchars($email_address),
                ':cash_balance' => htmlspecialchars($cash_balance),
            ]);
        }
    }

    //update user
    function update_user($user_id, $name_user, $email_address, $cash_balance) {
        global $database;
        
        //check form inputs
        if ($user_id !== false && $name_user !== '' && $email_address !== '' && $cash_balance !== false) {
            //update user
            $query = 'UPDATE users SET name = :name_user, email_address = :email_address, cash_balance = :cash_balance WHERE id = :user_id';
            $updated = execute_query($database, $query, [
                ':user_id' => htmlspecialchars($user_id),
                ':name_user' => htmlspecialchars($name_user),
                ':email_address' => htmlspecialchars($email_address),
                ':cash_balance' => htmlspecialchars($cash_balance),
            ]);
        }
    }   

    //delete user
    function delete_user($user_id) {
        global $database;
        
        //check form inputs
        if ($user_id !== false) {
            //delete user
            $query = "DELETE FROM users WHERE id = :user_id";
            $deleted = execute_query($database, $query, [':user_id' => htmlspecialchars($user_id)]);
        }
    }
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', 'stocks_error.log');
?>

