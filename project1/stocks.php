<?php

try {
    
    require_once './models/database.php';
    require_once './models/stocks.php';
    require_once './models/utilities.php';
    
    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));
    $symbol = htmlspecialchars(filter_input(INPUT_POST, "symbol"));
    $name = htmlspecialchars(filter_input(INPUT_POST, "name"));    
    $current_price = filter_input(INPUT_POST, "current_price", FILTER_VALIDATE_FLOAT);
    
    //display tables
    $stocks = display_stocks();
    include ('views/stocks.php');
    
    switch ($action) {
        case "insert_stock":
            insert_stock($symbol, $name, $current_price);
            header("Location: stocks.php");
            break;
        case "update_stock":
            update_stock($symbol, $name, $current_price);
            header("Location: stocks.php");
            break;
        case "delete_stock":
            delete_stock($symbol);
            header("Location: stocks.php");
            break;    
    }
    
} catch (Exception $e) {
    $error_message = $e->getMessage();
    include('./views/error.php');
}
?>

