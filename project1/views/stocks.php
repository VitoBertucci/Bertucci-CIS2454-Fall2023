<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <?php include ('nav.php') ?>
    </br>
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
                    <td><?php echo $stock->get_symbol(); ?></td>
                    <td><?php echo $stock->get_name(); ?></td>
                    <td><?php echo round($stock->get_current_price(), 2); ?></td>
                    <td><?php echo $stock->get_id(); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>


        <!-- Add a stock to the table -->
        <h2>Add or Update Stock</h2>
        <form action='stocks.php' method='post'>
            <input type='text' name='symbol' placeholder='Symbol'/><br>
            <input type='text' name='name' placeholder='Name'/><br>
            <input type='text' name='current_price' placeholder='Current Price'/><br>
            <input type='hidden' name='action' value='insert_or_update_stock'/><br>
            <input type="radio" name="insert_or_update_stock" value="insert" checked>Add</br>
            <input type="radio" name="insert_or_update_stock" value="update">Update</br>
            <label>&nbsp;</label>
            <input type='submit' value='Submit' /><br>
        </form>
        <!-- Delete a stock in the table -->
        <h2>Delete Stock</h2>
        <form action='stocks.php' method='post'>
            <?php include ("stockDropDown.php"); ?>
            <input type='hidden' name='action' value='delete_stock' /><br>
            <label>&nbsp;</label>
            <input type='submit' value='Delete Stock' /><br>
        </form>

    </body>
    </br>
    <?php include ('footer.php') ?>
</html>