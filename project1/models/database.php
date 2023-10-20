<?php
    // Database connection parameters
    $data_source_name = 'mysql:host=localhost;dbname=stock';
    $username = 'stockuser';
    $password = 'password1';
    $database = new PDO($data_source_name, $username, $password);
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', 'stocks_error.log');
?>

