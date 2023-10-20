<?php
    require_once './models/utilities.php';
    
    //display transactions
    function display_transactions() {
        global $database;
        
        $query = 'SELECT user_id, stock_id, quantity, price, timestamp, id FROM transactions';
        return execute_query($database, $query);
    }
    
    //insert transaction
    function insert_transaction($user_id, $symbol, $quantity) {
        global $database;
        
        //check form inputs
        if ($user_id !== "" && $symbol !== "" && $quantity !== false) {

            //get price of stock by symbol
            $query = 'SELECT current_price FROM stocks WHERE symbol = :symbol';
            $statement = execute_query($database, $query, [':symbol' => htmlspecialchars($symbol)]);

            //if current_price exists, store it
            if ($statement) {
                $stock_price = $statement->fetch(PDO::FETCH_ASSOC);

                //if price has been stored, get stock id
                if ($stock_price) {
                    $stock_id_query = 'SELECT id FROM stocks WHERE symbol = :symbol';
                    $stock_id_statement = execute_query($database, $stock_id_query, [':symbol' => htmlspecialchars($symbol)]);

                    //if stock_id exists, store it
                    if ($stock_id_statement) {
                        $stock_info = $stock_id_statement->fetch(PDO::FETCH_ASSOC);
                        $stock_id = $stock_info['id']; 

                        //calc transaction price
                        $price = $quantity * $stock_price['current_price'];

                        //get user balance from user_id
                        $userBalanceQuery = 'SELECT cash_balance FROM users WHERE id = :user_id';
                        $statement = execute_query($database, $userBalanceQuery, [':user_id' => htmlspecialchars($user_id)]);

                        //if that balance exists, store it
                        if ($statement) {
                            $user_balance = $statement->fetch(PDO::FETCH_ASSOC);
                            
                            //if user has enough money for the purchanse
                            if (($user_balance['cash_balance'] - $price) > 0) {
                                $update_query = 'UPDATE users SET cash_balance = cash_balance - :price WHERE id = :user_id';
                                $statement = execute_query($database, $update_query, [
                                    ':user_id' => htmlspecialchars($user_id),
                                    ':price' => htmlspecialchars($price),
                                ]);

                                //insert transaction into table
                                $insert_query = "INSERT INTO transactions (user_id, stock_id, quantity, price) VALUES (:user_id, :stock_id, :quantity, :price)";
                                $insert_statement = execute_query($database, $insert_query, [
                                    ':user_id' => htmlspecialchars($user_id),
                                    ':stock_id' => htmlspecialchars($stock_id), 
                                    ':quantity' => htmlspecialchars($quantity),
                                    ':price' => htmlspecialchars($price)
                                ]);
                            } else {
                                echo "User does not have enough money";
                            }
                        } else {
                            echo "Error retrieving user balance.";
                        }
                    } else {
                        echo "Error retrieving stock ID.";
                    }
                } else {
                    echo "No stock with that symbol";
                }
            } else {
                echo "Error retrieving stock price.";
            }
        }
    }

    //update transaction
    function update_transaction($transaction_id, $user_id, $stock_id, $quantity) {
        global $database;

        //check form inputs
        if ($transaction_id !== false && $user_id !== '' && $stock_id !== '' && $quantity !== false) {

            //update transaction
            $query = 'UPDATE transactions SET user_id = :user_id, stock_id = :stock_id, quantity = :quantity WHERE id = :transaction_id';
            $statement = execute_query($database, $query, [
                ':user_id' => htmlspecialchars($user_id),
                ':stock_id' => htmlspecialchars($stock_id),
                ':quantity' => htmlspecialchars($quantity),
                ':transaction_id' => htmlspecialchars($transaction_id)
            ]);
        }
    }

    //delete transaction
    function delete_transaction($transaction_id) {
        
        global $database;
        //check form input
        if ($transaction_id !== false) {
            
            //get user info from transaction 
            $query = "SELECT user_id, stock_id, quantity FROM transactions WHERE id = :transaction_id";
            $statement = execute_query($database, $query, [':transaction_id' => htmlspecialchars($transaction_id)]);
            $transaction_data = $statement->fetch(PDO::FETCH_ASSOC);
            $user_id = $transaction_data['user_id'];
            $stock_id = $transaction_data['stock_id'];
            $quantity = $transaction_data['quantity'];
            
            //get price from stock
            $query = 'SELECT current_price FROM stocks WHERE id = :stock_id';
            $statement = execute_query($database, $query, [':stock_id' => htmlspecialchars($stock_id)]);
            $stock_price = $statement->fetch(PDO::FETCH_ASSOC);
            $current_price = $stock_price['current_price'];
            
            //get user balance from transaction
            $query = 'SELECT cash_balance FROM users WHERE id = :user_id';
            $statement = execute_query($database, $query, [':user_id' => htmlspecialchars($user_id)]);
            $user_balance = $statement->fetch(PDO::FETCH_ASSOC);
            $new_balance = $user_balance['cash_balance'] + ($current_price * $quantity);
            
            //update user balance
            $query = 'UPDATE users SET cash_balance = :new_balance WHERE id = :user_id';
            $statement = execute_query($database, $query, [
                ':user_id' => htmlspecialchars($user_id),
                ':new_balance' => htmlspecialchars($new_balance)
            ]);            
            
            
            //delete transaction
            $query = "DELETE FROM transactions WHERE id = :transaction_id";
            $statement = execute_query($database, $query, [':transaction_id' => htmlspecialchars($transaction_id)]);
            
            

//            //get transaction data
//            $query = "SELECT user_id, stock_id, quantity FROM transactions WHERE id = :transaction_id";
//            $statement = execute_query($database, $query, [':transaction_id' => htmlspecialchars($transaction_id)]);
//
//            //if data exists, store it
//            if ($statement) {
//                $transaction_data = $statement->fetch(PDO::FETCH_ASSOC);
//
//                //if data has been stored, map it
//                if ($transaction_data) {
//                    $user_id = $transaction_data['user_id'];
//                    $stock_id = $transaction_data['stock_id'];
//                    $quantity = $transaction_data['quantity'];
//
//                    //get current_price from stock by id
//                    $query = 'SELECT current_price FROM stocks WHERE id = :stock_id';
//                    $statement = execute_query($database, $query, [':stock_id' => htmlspecialchars($stock_id)]);
//
//                    //if price exists, store it
//                    if ($statement) {
//                        $stock_price = $statement->fetch(PDO::FETCH_ASSOC);
//
//                        //if price has been stored
//                        if ($stock_price) {
//                            $current_price = $stock_price['current_price'];
//
//                            //get balance from user by id 
//                            $query = 'SELECT cash_balance FROM users WHERE id = :user_id';
//                            $statement = execute_query($database, $query, [':user_id' => htmlspecialchars($user_id)]);
//
//                            //if balance has been found, store it
//                            if ($statement) {
//                                $user_balance = $statement->fetch(PDO::FETCH_ASSOC);
//
//                                //if balance has been stored
//                                if ($user_balance) {
//                                    $new_balance = $user_balance['cash_balance'] + ($current_price * $quantity);
//
//                                    //update user balance
//                                    $updateQuery = 'UPDATE users SET cash_balance = :new_balance WHERE id = :user_id';
//                                    
//                                    $updateStatement = execute_query($database, $updateQuery, [
//                                        ':user_id' => htmlspecialchars($user_id),
//                                        ':new_balance' => htmlspecialchars($new_balance)
//                                    ]);
//
//                                    //delete transaction
//                                    $deleteQuery = "DELETE FROM transactions WHERE id = :transaction_id";
//                                     $deleteStatement = execute_query($database, $deleteQuery, [':transaction_id' => htmlspecialchars($transaction_id)]);
//                                    
//                                    if ($deleteStatement) {
//                                        header("Location: " . $_SERVER['REQUEST_URI']);
//                                        exit;
//                                    } else {
//                                        echo "<p>Error deleting transaction.</p>";
//                                    }
//                                } else {
//                                    echo "User not found";
//                                }
//                            } else {
//                                echo "Error retrieving user balance.";
//                            }
//                        } else {
//                            echo "Stock not found";
//                        }
//                    } else {
//                        echo "Error retrieving stock price.";
//                    }
//                } else {
//                    echo "Transaction not found";
//                }
//            } else {
//                echo "Error retrieving transaction data.";
//            }
        }
    }
    
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', 'stocks_error.log');
?>

