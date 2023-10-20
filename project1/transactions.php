<?php

try {
    
    require_once './models/database.php';
    require_once './models/transactions.php';
    require_once './models/utilities.php';
    
    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));
    $user_id = filter_input(INPUT_POST, "user_id");
    $symbol = htmlspecialchars(filter_input(INPUT_POST, "symbol"));
    $quantity = filter_input(INPUT_POST, "quantity");
    $transaction_id = filter_input(INPUT_POST, "transaction_id");
    $stock_id = filter_input(INPUT_POST, "stock_id");
    
    
    //display tables
    $transactions = display_transactions();
    include ('views/transactions.php');
    
    switch ($action) {
        case "insert_transaction":
            insert_transaction($user_id, $symbol, $quantity);
            header("Location: transactions.php");
            break;
        case "update_transaction":
            update_transaction($transaction_id, $user_id, $stock_id, $quantity);
            header("Location: transactions.php");
            break;
        case "delete_transaction":
            delete_transaction($transaction_id);
            header("Location: transactions.php");
            break;
    }
    
} catch (Exception $e) {
    $error_message = $e->getMessage();
    include('views/error.php');
}

error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', 'stocks_error.log');
?>