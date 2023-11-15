<?php

try {
    require_once './models/utilities.php';
    require_once './models/database.php';
    require_once './models/stocks.php';

    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));
    $symbol = htmlspecialchars(filter_input(INPUT_POST, "symbol"));
    $name = htmlspecialchars(filter_input(INPUT_POST, "name"));
    $current_price = filter_input(INPUT_POST, "current_price", FILTER_VALIDATE_FLOAT);

    switch ($action) {
        case "insert_or_update_stock":
            if ($symbol !== "" && $name !== "" && $current_price !== false) {
                $insert_or_update_stock = filter_input(INPUT_POST, 'insert_or_update_stock');

                $stock = new Stock($symbol, $name, $current_price);

                if ($insert_or_update_stock == "insert") {
                    insert_stock($stock);
                } else if ($insert_or_update_stock == "update") {
                    update_stock($stock);
                }
            }
            header("Location: stocks.php");
            break;
        case "delete_stock":
            if ($symbol !== false) {
                $stock = new Stock($symbol, "", 0);
                delete_stock($stock);
            }
            header("Location: stocks.php");
            break;
        default:
            break;
    }

    $stocks = display_stocks();
    include ('views/stocks.php');
} catch (Exception $e) {
    $error_message = $e->getMessage();
    include('./views/error.php');
}
?>