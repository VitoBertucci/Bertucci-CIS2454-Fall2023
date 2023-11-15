<?php

try {

    require_once './models/utilities.php';
    require_once './models/database.php';
    require_once './models/transactions.php';
    require_once './models/stocks.php';
    require_once './models/users.php';

    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));
    $user_id = filter_input(INPUT_POST, "user_id");
    $stock_id = htmlspecialchars(filter_input(INPUT_POST, "stock_id"));
    $quantity = filter_input(INPUT_POST, "quantity");

    switch ($action) {
        case "insert_or_update_transaction":
            if ($user_id !== "" && $stock_id !== "" && $quantity !== false) {
                $insert_or_update_transaction = filter_input(INPUT_POST, 'insert_or_update_transaction');
                if ($insert_or_update_transaction == "insert") {
                    $stocks = display_stocks();
                    foreach ($stocks as $stock) {
                        if ($stock->get_id() == $stock_id) {
                            $stock_price = $stock->get_current_price();
                        }
                    }

                    $users = display_users();
                    foreach ($users as $user) {
                        if ($user->get_id() == $user_id) {
                            $user_balance = $user->get_cash_balance();
                        }
                    }

                    if ($user_balance >= ($stock_price * $quantity)) {
                        $transaction = new Transaction($user_id, $stock_id, $quantity, ($stock_price * $quantity));
                        insert_transaction($transaction);

                        $query = 'UPDATE users SET cash_balance = cash_balance - :price WHERE id = :user_id';
                        execute_query($database, $query, $params = [
                            ':price' => ($stock_price * $quantity),
                            ':user_id' => $user_id
                        ]);
                    }
                } else if ($insert_or_update_transaction == "update") {
                    $price = filter_input(INPUT_POST, "price");
                    $transaction_id = filter_input(INPUT_POST, "transaction_id");
                    $transaction = new Transaction($user_id, $stock_id, $quantity, $price, $timestamp = "", $transaction_id);
                    update_transaction($transaction);
                }
            }
            header("Location: transactions.php");
            break;
        case "delete_transaction":
            $transaction_id = filter_input(INPUT_POST, "transaction_id");

            if ($transaction_id !== false) {
                $transactions = display_transactions();
                foreach ($transactions as $transaction) {
                    if ($transaction->get_id() == $transaction_id) {
                        $stock_id = $transaction->get_stock_id();
                        $user_id = $transaction->get_user_id();
                        $quantity = $transaction->get_quantity();
                    }
                }

                $stocks = display_stocks();
                foreach ($stocks as $stock) {
                    if ($stock->get_id() == $stock_id) {
                        $stock_price = $stock->get_current_price();
                    }
                }

                $query = 'UPDATE users SET cash_balance = cash_balance + :price WHERE id = :user_id';
                execute_query($database, $query, $params = [
                    ':price' => ($stock_price * $quantity),
                    ':user_id' => $user_id
                ]);

                $transaction = new Transaction(0, 0, 0, 0, "", $transaction_id);
                delete_transaction($transaction);
            }
            header("Location: transactions.php");
            break;
    }

    $transactions = display_transactions();
    include ('views/transactions.php');
} catch (Exception $e) {
    $error_message = $e->getMessage();
    include('views/error.php');
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'stocks_error.log');
?>