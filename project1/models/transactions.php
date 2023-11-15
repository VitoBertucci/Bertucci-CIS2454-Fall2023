<?php

require_once './models/utilities.php';

class Transaction {

    private $user_id, $stock_id, $quantity, $price, $timestamp, $id;

    public function __construct($user_id, $stock_id, $quantity, $price, $timestamp = "", $id = 0) {
        $this->set_user_id($user_id);
        $this->set_stock_id($stock_id);
        $this->set_quantity($quantity);
        $this->set_price($price);
        $this->set_timestamp($timestamp);
        $this->set_id($id);
    }

    public function get_user_id() {
        return $this->user_id;
    }

    public function get_stock_id() {
        return $this->stock_id;
    }

    public function get_quantity() {
        return $this->quantity;
    }

    public function get_price() {
        return $this->price;
    }

    public function get_timestamp() {
        return $this->timestamp;
    }

    public function get_id() {
        return $this->id;
    }

    public function set_user_id($user_id) {
        $this->user_id = $user_id;
    }

    public function set_stock_id($stock_id) {
        $this->stock_id = $stock_id;
    }

    public function set_quantity($quantity) {
        $this->quantity = $quantity;
    }

    public function set_price($price) {
        $this->price = $price;
    }

    public function set_timestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    public function set_id($id) {
        $this->id = $id;
    }

}

//display transactions
function display_transactions() {
    global $database;

    $query = 'SELECT user_id, stock_id, quantity, price, timestamp, id FROM transactions';

    $transactions = execute_query($database, $query);

    $transactions_arr = array();

    foreach ($transactions as $transaction) {
        $transactions_arr[] = $new_transaction = new Transaction(
                $transaction['user_id'],
                $transaction['stock_id'],
                $transaction['quantity'],
                $transaction['price'],
                $transaction['timestamp'],
                $transaction['id']
        );
    }

    return $transactions_arr;
}

//insert transaction
function insert_transaction($transaction) {
    global $database;

    $query = "INSERT INTO transactions (user_id, stock_id, quantity, price) VALUES (:user_id, :stock_id, :quantity, :price)";
    execute_query($database, $query, [
        ':user_id' => $transaction->get_user_id(),
        ':stock_id' => $transaction->get_stock_id(),
        ':quantity' => $transaction->get_quantity(),
        ':price' => $transaction->get_price()
    ]);
}

function update_transaction($transaction) {
    global $database;

    //update transaction
    $query = 'UPDATE transactions SET user_id = :user_id, stock_id = :stock_id, quantity = :quantity, price = :price'
            . ' WHERE id = :id';
    execute_query($database, $query, [
        ':user_id' => $transaction->get_user_id(),
        ':stock_id' => $transaction->get_stock_id(),
        ':quantity' => $transaction->get_quantity(),
        ':price' => $transaction->get_price(),
        ':id' => $transaction->get_id(),
    ]);
}

//delete transaction
function delete_transaction($transaction) {
    global $database;

    //delete stock
    $query = "DELETE FROM transactions WHERE id = :transaction_id";
    execute_query($database, $query, [':transaction_id' => $transaction->get_id()]);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'stocks_error.log');
?>

