<?php

require_once './models/utilities.php';

class User {

    private $name, $email_address, $cash_balance, $id;

    public function __construct($name, $email_address, $cash_balance, $id = 0) {
        $this->set_name($name);
        $this->set_email_address($email_address);
        $this->set_cash_balance($cash_balance);
        $this->set_id($id);
    }

    public function get_name() {
        return $this->name;
    }

    public function get_email_address() {
        return $this->email_address;
    }

    public function get_cash_balance() {
        return $this->cash_balance;
    }

    public function get_id() {
        return $this->id;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function set_email_address($email_address) {
        $this->email_address = $email_address;
    }

    public function set_cash_balance($cash_balance) {
        $this->cash_balance = $cash_balance;
    }

    public function set_id($id) {
        $this->id = $id;
    }

}

//display users
function display_users() {
    global $database;

    $query = 'SELECT name, email_address, cash_balance, id FROM users';

    $users = execute_query($database, $query);

    $users_arr = array();

    foreach ($users as $user) {
        $users_arr[] = $new_user = new user(
                $user['name'],
                $user['email_address'],
                $user['cash_balance'],
                $user['id']
        );
    }
    return $users_arr;
}

//insert user
function insert_user($user) {
    global $database;

    //insert user
    $query = 'INSERT INTO users (name, email_address, cash_balance) VALUES (:name, :email_address, :cash_balance)';
    execute_query($database, $query, [
        ':name' => $user->get_name(),
        ':email_address' => $user->get_email_address(),
        ':cash_balance' => $user->get_cash_balance()
    ]);
}

//update user
function update_user($user) {
    global $database;

    //update user
    $query = 'UPDATE users SET name = :name, email_address = :email_address, cash_balance = :cash_balance WHERE name = :name';
    execute_query($database, $query, [
        ':name' => $user->get_name(),
        ':email_address' => $user->get_email_address(),
        ':cash_balance' => $user->get_cash_balance()
    ]);
}

//delete user
function delete_user($user) {
    global $database;

    //delete user
    $query = "DELETE FROM users WHERE id = :user_id";

    execute_query($database, $query, [':user_id' => $user->get_id()]);
}
?>

