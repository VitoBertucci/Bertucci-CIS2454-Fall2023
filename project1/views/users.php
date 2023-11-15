<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <?php include ('nav.php') ?>
    </br>
    <body>
        <h2>Users</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Email Address</th>
                <th>Cash Balance</th>
                <th>ID</th>
            </tr>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo $user->get_name() ?></td>
                    <td><?php echo $user->get_email_address() ?></td>
                    <td><?php echo round($user->get_cash_balance(), 2) ?></td>
                    <td><?php echo $user->get_id() ?></td>
                </tr>
            <?php endforeach; ?>
        </table>


        <!-- Add a user to the table -->
        <h2>Add or Update User</h2>
        <form action='users.php' method='post'>
            <input type='text' name='name' placeholder='Name'/><br>
            <input type='text' name='email_address' placeholder='Email Address'/><br>
            <input type='text' name='cash_balance' placeholder='Cash Balance'/><br>
            <input type='hidden' name='action' value='insert_or_update_user' /><br>
            <input type="radio" name="insert_or_update_user" value="insert" checked>Add</br>
            <input type="radio" name="insert_or_update_user" value="update">Update</br>
            <label>&nbsp;</label>
            <input type='submit' value='Submit' /><br>
        </form>
        <!-- Delete a user in the table -->
        <h2>Delete User</h2>
        <form action='users.php' method='post'>
            <?php include ("userDropDown.php"); ?>
            <input type='hidden' name='action' value='delete_user' /><br>
            <label>&nbsp;</label>
            <input type='submit' value='Delete User' /><br>
        </form>

    </body>
    </br>
    <?php include ('footer.php') ?>
</html>