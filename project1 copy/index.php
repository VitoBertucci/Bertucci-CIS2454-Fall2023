<?php
$data_source_name = 'mysql:host=localhost;dbname=stock';
$username = 'stockuser';
$password = 'password1';

try {
    $database = new PDO($data_source_name, $username, $password);
    echo "<p>Database connection successful </p";

    $query = 'SELECT symbol, name, current_price, id FROM stocks';
    $statement = $database->prepare($query);
    $statement->execute();
    $stocks = $statement->fetchAll();
    $statement->closeCursor();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $symbol = htmlspecialchars(filter_input(INPUT_POST, "symbol"));
        $name = htmlspecialchars(filter_input(INPUT_POST, "name"));
        $current_price = filter_input(INPUT_POST, "current_price", FILTER_VALIDATE_FLOAT);

        if ($symbol != "" && $name != "" && $current_price !== false) {
            $query = "INSERT INTO stocks (symbol, name, current_price) VALUES (:symbol, :name, :current_price)";
            $statement = $database->prepare($query);
            $statement->bindValue(":symbol", $symbol);
            $statement->bindValue(":name", $name);
            $statement->bindValue(":current_price", $current_price);
            $statement->execute();
            $statement->closeCursor();
        }
    }
} catch (Exception $e) {
    $error_message = $e->getMessage();
    echo "<p>Error Message: $error_message</p>";
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <table>
            <tr>
                <th>Symbol</th>
                <th>Name</th>
                <th>current Price</th>
                <th>ID</th>
            </tr>
            <?php foreach($stocks as $stock) : ?>
            <tr>
                <td><?php echo $stock['symbol'] ?></td>
                <td><?php echo $stock['name'] ?></td>
                <td><?php echo $stock['current_price'] ?></td>
                <td><?php echo $stock['id'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <h2>Add Stock</h2>
        
        <form action='index.php' method='post'>
            <label>Symbol</label>
            <input type='text' name='symbol' /><br>
            <label>Name</label>
            <input type='text' name='name' /><br>
            <label>current Price</label>
            <input type='text' name='current_price' /><br>
            <label>&nbsp;</label>
            <input type='submit' value='Add Stock' /><br>
        </form>
        
    </body>
</html>
