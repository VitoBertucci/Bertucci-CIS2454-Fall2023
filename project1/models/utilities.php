<?php

    //function to execute a query and handle errors
    function execute_query(PDO $database, $query, $params = []) {
        
        $statement = $database->prepare($query);
        foreach ($params as $param => $value) {
            $statement->bindValue($param, $value);
        }
        
        
        
        if ($statement->execute()) {
            return $statement;
        } else {
            echo $statement->errorInfo();
            return false;
        }
    }
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', 'stocks_error.log');
?>

