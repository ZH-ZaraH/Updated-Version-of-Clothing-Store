<?php
session_start();
require_once '../me_core/medbConfig.php';
require_once '../me_core/meModels.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Store</title>
    <link rel="stylesheet" href="cs_styles.css">
</head>
<body>
    <?php if (isset($_SESSION['user_id'])) { ?>
        <h1 style="color:red;"><?php echo $_SESSION['message'] ?? ''; ?></h1>
    <?php } unset($_SESSION['message']); ?>

    <?php if (isset($_SESSION['username'])) { ?>
        <h1>˚.⋆꒰১ ໒꒱⋆.˚Welcome To BowTique, <?php echo $_SESSION['username']; ?> ˚.⋆꒰১ ໒꒱⋆.˚</h1>
        <a href="../me_core/meHandleForms.php?logoutUser=1">Logout</a>
            <h2>Add New Customer</h2>
        <form action="../me_core/meHandleForms.php" method="POST">
            <p>
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" required>
            </p>
            <p>
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" required>
            </p>
            <p>
                <label for="contact_number">Contact Number</label>
                <input type="text" name="contact_number" required>
            </p>
            <p>
                <label for="email">Email</label>
                <input type="text" name="email" required>
            </p>
            <p>
                <label for="address">Address</label>
                <input type="text" name="address" required>
            </p>
            <p>
                <label for="city">City</label>
                <input type="text" name="city" required>
            </p>
            <p>
                <label for="province">Province</label>
                <input type="text" name="province" required>
            </p>
            <p>
                <label for="postal_code">Postal Code</label>
                <input type="text" name="postal_code" required>
            </p>
            <input type="submit" name="addCustomerBtn" value="Add Customer">
        </form>

    <hr>
    <h2>Your Customer Records</h2>
    <?php 
    // Fetch only the customers created by the currently logged-in user
    $getCustomersByUser = getCustomersByUser($pdo, $_SESSION['user_id']); 
    foreach ($getCustomersByUser as $row) { 
    ?>
    <div class="container" style="border-style: solid; width: 50%; padding: 10px; margin-top: 20px;">
        <h3>First Name: <?php echo $row['first_name']; ?></h3>
        <h3>Last Name: <?php echo $row['last_name']; ?></h3>
        <h3>Contact Number: <?php echo $row['contact_number']; ?></h3>
        <h3>Email: <?php echo $row['email']; ?></h3>
        <h3>Address: <?php echo $row['address']; ?></h3>
        <h3>City: <?php echo $row['city']; ?></h3>
        <h3>Province: <?php echo $row['province']; ?></h3>
        <h3>Postal Code: <?php echo $row['postal_code']; ?></h3>
        <h3>Date Added: <?php echo $row['last_updated']; ?></h3>
        <h3 style="color: blue;">Added By: <?php echo $row['added_by_user']; ?></h3>
        <h3 style="color: blue;">Last Updated: <?php echo $row['last_updated']; ?></h3>
    
        <div class="Edit_and_Delete" style="margin-top: 10px;">
            <a href="vieworders.php?customer_id=<?php echo $row['customer_id']; ?>">View Orders</a> 
            <a href="edit_customer.php?customer_id=<?php echo $row['customer_id']; ?>">Edit</a> 
            <a href="delete_customer.php?customer_id=<?php echo $row['customer_id']; ?>">Delete</a>
        </div>
    </div>
    <?php } ?> 
    <?php } else { echo "<h1>No user logged in</h1>";} ?> 
</body>
</html>