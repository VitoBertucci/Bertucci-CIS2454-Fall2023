<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
    <?php include ('nav.php') ?>
    <body>
        <h2>Stocks</h2>
        <table>
            <tr>
                <th>Symbol</th>
                <th>Name</th>
                <th>Current Price</th>
                <th>ID</th>
            </tr>
            <?php foreach ($stocks as $stock) : ?>
                <tr>
                    <td><?php echo $stock['symbol'] ?></td>
                    <td><?php echo $stock['name'] ?></td>
                    <td><?php echo round($stock['current_price'], 2) ?></td>
                    <td><?php echo $stock['id'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        
    
        <!-- Add a stock to the table -->
        <h2>Add Stock</h2>
        <form action='stocks.php' method='post'>
            <input type='text' name='symbol' placeholder='Symbol'/><br>
            <input type='text' name='name' placeholder='Name'/><br>
            <input type='text' name='current_price' placeholder='Current Price'/><br>
            <input type='hidden' name='action' value='insert_stock'/><br>
            <label>&nbsp;</label>
            <input type='submit' value='Add Stock' /><br>
        </form>
        <!-- Update a stock in the table -->
        <h2>Update Stock</h2>
        <form action='stocks.php' method='post'>
            <input type='text' name='symbol' placeholder='Symbol'/><br>
            <input type='text' name='name' placeholder='New Name'/><br>
            <input type='text' name='current_price' placeholder='New Current Price'/><br>
            <input type='hidden' name='action' value='update_stock' /><br>
            <label>&nbsp;</label>
            <input type='submit' value='Update Stock' /><br>
        </form>
        <!-- Delete a stock in the table -->
        <h2>Delete Stock</h2>
        <form action='stocks.php' method='post'>
            <input type='text' name='symbol' placeholder='Symbol'/><br>
            <input type='hidden' name='action' value='delete_stock' /><br>
            <label>&nbsp;</label>
            <input type='submit' value='Delete Stock' /><br>
        </form>
        
    </body>
    <?php include ('footer.php') ?>
</html>