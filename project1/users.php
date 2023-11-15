<?php

try {

    require_once './models/utilities.php';
    require_once './models/database.php';
    require_once './models/users.php';

    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));
    $user_id = filter_input(INPUT_POST, "user_id");
    $email_address = htmlspecialchars(filter_input(INPUT_POST, "email_address"));
    $name = htmlspecialchars(filter_input(INPUT_POST, "name"));
    $cash_balance = filter_input(INPUT_POST, "cash_balance");

    switch ($action) {
        case "insert_or_update_user":
            if ($name !== '' && $email_address !== '' && $cash_balance !== false) {
                $insert_or_update_user = filter_input(INPUT_POST, 'insert_or_update_user');

                $user = new User($name, $email_address, $cash_balance);

                if ($insert_or_update_user == "insert") {
                    insert_user($user);
                } else if ($insert_or_update_user == "update") {
                    update_user($user);
                }
            }
            header("Location: users.php");
            break;
        case "delete_user":

            if ($user_id !== false) {
                $user = new User("", "", 0, $user_id);
                delete_user($user);
            }
            header("Location: users.php");
            break;
    }

    $users = display_users();
    include ('views/users.php');
} catch (Exception $e) {
    $error_message = $e->getMessage();
    include('./views/error.php');
}
?>
