<?php

    require_once './models/utilities.php'; 

    //display stocks
    function display_stocks() {
        global $database;
        
        $query = 'SELECT symbol, name, current_price, id FROM stocks';
        return execute_query($database, $query);
    }
    
    
    //insert stock
    function insert_stock($symbol, $name, $current_price) {
        global $database;
        
        //check form inputs
        if ($symbol !== "" && $name !== "" && $current_price !== false) {
            //insert stock
            $query = "INSERT INTO stocks (symbol, name, current_price) VALUES (:symbol, :name, :current_price)";
            $inserted = execute_query($database, $query, [
                ':symbol' => htmlspecialchars($symbol),
                ':name' => htmlspecialchars($name),
                ':current_price' => htmlspecialchars($current_price),
            ]);
        }
    }
    
    //update stock
    function update_stock($symbol, $name, $current_price) {
        global $database;
        
        //check form inputs
        if ($symbol !== "" && $name !== "" && $current_price !== false) {
            //update stock
            $query = "UPDATE stocks SET name = :name, current_price = :current_price WHERE symbol = :symbol";
            $updated = execute_query($database, $query, [
                ':symbol' => htmlspecialchars($symbol),
                ':name' => htmlspecialchars($name),
                ':current_price' => htmlspecialchars($current_price),
            ]);  
        }
    }
    
    //delete stock
    function delete_stock($symbol) {
        global $database;
        
        //check form input
        if ($symbol !== false) {
            //delete stock
            $query = "DELETE FROM stocks WHERE symbol = :symbol";
            $deleted = execute_query($database, $query, [':symbol' => htmlspecialchars($symbol)]);
        }
    }
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', 'stocks_error.log');

    
?>

