<?php require_once '../me_core/medbConfig.php'; ?>
<?php require_once '../me_core/meModels.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <title>Clothing Store</title>
    <link rel="stylesheet" href="cs_styles.css">
</head>
<body>
    <?php if (isset($_SESSION['message'])) { ?>
        <h1 style="color: red;"><?php echo $_SESSION['message'];?> </h1>
    <?php } unset($_SESSION['message']); ?>
    <h1>Welcome to Bowtique Please LogIn</h1>
    <form action="../me_core/meHandleForms.php" method="POST">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username">
        </p>
        <p>
            <label for="password">Password</label>
            <input type="text" name="password">
            <input type="submit" name="loginUserBtn" value="Log In">
    </form>
    <p>Don't have an account? Please Register here <a href="register.php">here</a></p>  

</body>

</html>