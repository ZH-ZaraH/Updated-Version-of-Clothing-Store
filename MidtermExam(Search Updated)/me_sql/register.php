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
    <h1>Register Here</h1>
    <?php if (isset($_SESSION['message'])) { ?>
        <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
    <?php } unset($_SESSION['message']); ?>
    <form action="../me_core/meHandleForms.php" method="POST">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username">
        </p>
        <p>
            <label for="first_name">First Name</label>
            <input type="text" name="first_name">
        </p>
        <p>
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name">
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </p>
        <p>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password">
            <input type="submit" name="registerUserBtn" required value="Register">
        </p>
    </form>
</body>
</html>