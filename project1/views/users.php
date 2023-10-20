<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
    <?php include ('nav.php') ?>
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
                    <td><?php echo $user['name'] ?></td>
                    <td><?php echo $user['email_address'] ?></td>
                    <td><?php echo round($user['cash_balance'], 2) ?></td>
                    <td><?php echo $user['id'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        
    
         <!-- Add a user to the table -->
        <h2>Add User</h2>
        <form action='users.php' method='post'>
            <input type='text' name='name_user' placeholder='Name'/><br>
            <input type='text' name='email_address' placeholder='Email Address'/><br>
            <input type='text' name='cash_balance' placeholder='Cash Balance'/><br>
            <input type='hidden' name='action' value='insert_user' /><br>
            <label>&nbsp;</label>
            <input type='submit' value='Add User' /><br>
        </form>
        <!-- Update a user in the table -->
        <h2>Update User</h2>
        <form action='users.php' method='post'>
            <input type='text' name='user_id' placeholder='User ID'/><br>
            <input type='text' name='name_user' placeholder='New Name'/><br>
            <input type='text' name='email_address' placeholder='New Email Address'/><br>
            <input type='text' name='cash_balance' placeholder='New Cash Balance'/><br>
            <input type='hidden' name='action' value='update_user' /><br>
            <label>&nbsp;</label>
            <input type='submit' value='Update User' /><br>
        </form>
        <!-- Delete a user in the table -->
        <h2>Delete User</h2>
        <form action='users.php' method='post'>
            <input type='text' name='user_id' placeholder='User ID'/><br>
            <input type='hidden' name='action' value='delete_user' /><br>
            <label>&nbsp;</label>
            <input type='submit' value='Delete User' /><br>
        </form>
        
    </body>
    <?php include ('footer.php') ?>
</html>