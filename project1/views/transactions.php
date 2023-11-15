<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <?php include ('nav.php') ?>
    </br>
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
                    <td><?php echo $transaction->get_user_id(); ?></td>
                    <td><?php echo $transaction->get_stock_id(); ?></td>
                    <td><?php echo $transaction->get_quantity(); ?></td>
                    <td><?php echo round($transaction->get_price(), 2); ?></td>
                    <td><?php echo $transaction->get_timestamp(); ?></td>
                    <td><?php echo $transaction->get_id(); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>


        <!-- Add or Update Transaction -->
        <h2>Add or Update Transaction</h2>
        <form action='transactions.php' method='post'>
            <input type='text' name='user_id' placeholder='User ID'/><br>
            <input type='text' name='stock_id' placeholder='Stock ID'/><br>
            <input type='text' name='quantity' placeholder='Quantity'/><br>
            <input type='text' name='transaction_id' placeholder='Transaction ID (Update Only)'/><br>
            <input type='text' name='price' placeholder='Price (Update Only)'/><br>
            <input type='hidden' name='action' value='insert_or_update_transaction'/><br>
            <input type="radio" name="insert_or_update_transaction" value="insert" checked>Add</br>
            <input type="radio" name="insert_or_update_transaction" value="update">Update</br>
            <label>&nbsp;</label>
            <input type='submit' value='Submit' /><br>
        </form>
        <!-- Delete a transaction in the table -->
        <h2>Delete Transaction</h2>
        <form action='transactions.php' method='post'>
            <?php include ("transactionDropDown.php"); ?>
            <input type='hidden' name='action' value='delete_transaction' /><br>
            <label>&nbsp;</label>
            <input type='submit' value='Delete Transaction' /><br>
        </form>

    </body>
    </br>
    <?php include ('footer.php') ?>
</html>