<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
    <?php include ('nav.php') ?>
    <body>
        <h2>Transactions</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Stock ID</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Timestamp</th>
                <th>ID</th>
            </tr>
            <?php foreach ($transactions as $transaction) : ?>
                <tr>
                    <td><?php echo $transaction['user_id'] ?></td>
                    <td><?php echo $transaction['stock_id'] ?></td>
                    <td><?php echo $transaction['quantity'] ?></td>
                    <td><?php echo round($transaction['price'], 2) ?></td>
                    <td><?php echo $transaction['timestamp'] ?></td>
                    <td><?php echo $transaction['id'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        
    
        <!-- Add a transaction to the table -->
        <h2>Add Transaction</h2>
        <form action='transactions.php' method='post'>
            <input type='text' name='user_id' placeholder='User ID'/><br>
            <input type='text' name='symbol' placeholder='Stock Symbol'/><br>
            <input type='text' name='quantity' placeholder='Quantity'/><br>
            <input type='hidden' name='action' value='insert_transaction' /><br>
            <label>&nbsp;</label>
            <input type='submit' value='Add Transaction' /><br>
        </form>
        <!-- Update a transaction in the table -->
        <h2>Update Transaction</h2> 
        <form action='transactions.php' method='post'>
            <input type='text' name='transaction_id' placeholder='Transaction ID'/><br>
            <input type='text' name='user_id' placeholder='New User ID'/><br>
            <input type='text' name='stock_id' placeholder='New Stock ID'/><br>
            <input type='text' name='quantity' placeholder='New Quantity'/><br>
            <input type='hidden' name='action' value='update_transaction' /><br>
            <label>&nbsp;</label>
            <input type='submit' value='Update Transaction' /><br>
        </form>
        <!-- Delete a transaction in the table -->
        <h2>Delete Transaction</h2>
        <form action='transactions.php' method='post'>
            <input type='text' name='transaction_id' placeholder='Transaction ID'/><br>
            <input type='hidden' name='action' value='delete_transaction' /><br>
            <label>&nbsp;</label>
            <input type='submit' value='Delete Transaction' /><br>
        </form>
        
    </body>
    <?php include ('footer.php') ?>
</html>