<?php

require_once './models/utilities.php';

class Stock {

    private $symbol, $name, $current_price, $id;

    public function __construct($symbol, $name, $current_price, $id = 0) {
        $this->set_symbol($symbol);
        $this->set_name($name);
        $this->set_current_price($current_price);
        $this->set_id($id);
    }

    public function get_symbol() {
        return $this->symbol;
    }

    public function get_name() {
        return $this->name;
    }

    public function get_current_price() {
        return $this->current_price;
    }

    public function get_id() {
        return $this->id;
    }

    public function set_symbol($symbol) {
        $this->symbol = $symbol;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function set_current_price($current_price) {
        $this->current_price = $current_price;
    }

    public function set_id($id) {
        $this->id = $id;
    }

}

//display stocks
function display_stocks() {
    global $database;

    $query = 'SELECT symbol, name, current_price, id FROM stocks';

    $stocks = execute_query($database, $query);

    $stocks_arr = array();

    foreach ($stocks as $stock) {
        $stocks_arr[] = $new_stock = new Stock(
                $stock['symbol'],
                $stock['name'],
                $stock['current_price'],
                $stock['id']
        );
    }
    return $stocks_arr;
}

//insert stock
function insert_stock($stock) {
    global $database;

    //insert stock
    $query = "INSERT INTO stocks (symbol, name, current_price) VALUES (:symbol, :name, :current_price)";
    execute_query($database, $query, [
        ':symbol' => $stock->get_symbol(),
        ':name' => $stock->get_name(),
        ':current_price' => $stock->get_current_price(),
    ]);
}

//update stock
function update_stock($stock) {
    global $database;

    //update stock
    $query = "UPDATE stocks SET name = :name, current_price = :current_price WHERE symbol = :symbol";
    execute_query($database, $query, [
        ':symbol' => $stock->get_symbol(),
        ':name' => $stock->get_name(),
        ':current_price' => $stock->get_current_price(),
    ]);
}

//delete stock
function delete_stock($stock) {
    global $database;

    //delete stock
    $query = "DELETE FROM stocks WHERE symbol = :symbol";
    execute_query($database, $query, [':symbol' => $stock->get_symbol()]);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'stocks_error.log');
?>

