<?php
session_start();

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] == false ) {
    if (basename($_SERVER['PHP_SELF']) != 'login.php') {
        header("Location: index.php");
        exit(); // Don't forget to call exit() after header()
    }
}

//function to execute a query and handle errors
function execute_query(PDO $database, $query, $params = []) {
    $statement = $database->prepare($query);
    foreach ($params as $param => $value) {
        $statement->bindValue($param, $value);
    }

    if ($statement->execute()) {
        // If $params is empty, fetch results; otherwise, return the statement
        if (empty($params)) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return $statement;
    } else {
        echo $statement->errorInfo();
        return false;
    }
}
?>

