<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <?php include ('nav.php') ?>
    </br>
    <body>
        <h2>Login</h2>
        <?php echo $message ?>
        <form action='login.php' method='post'>
            <input type='text' name='email_address' placeholder='Email Address' /><br>
            <input type='password' name='password' placeholder='Password' /><br>
            <label>&nbsp;</label>
            <input type='submit' value='Login' /><br>
        </form>
    </body>
    </br>
    <?php include ('footer.php') ?>
</html>
