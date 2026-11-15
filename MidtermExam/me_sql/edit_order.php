<?php
require_once '../me_core/medbConfig.php';
require_once '../me_core/meModels.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Store - Edit Order</title>
    <link rel="stylesheet" href="cs_styles.css">
</head>
<body>
    <a href="vieworders.php?customer_id=<?php echo htmlspecialchars($_GET['customer_id']); ?>">View Orders</a>
    <h1>Edit Order</h1>
    
    <?php 
    // Fetch using order_id, not customer_id!
    $getOrderById = getOrderById($pdo, $_GET['order_id']); 
    ?>
    
    <form action="../me_core/meHandleForms.php?order_id=<?php echo ($_GET['order_id']); ?>&customer_id=<?php echo htmlspecialchars($_GET['customer_id']); ?>" method="POST">
        <p>
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" value="<?php echo ($getOrderById['product_name']); ?>" required>
        </p>
        <p>
            <label for="category">Category</label>
            <input type="text" name="category" value="<?php echo ($getOrderById['category']); ?>" required>
        </p>
        <p>
            <label for="size_code">Size</label>
            <input type="text" name="size_code" value="<?php echo ($getOrderById['size_code']); ?>" required>
        </p>
        <p>
            <label for="color">Color</label>
            <input type="text" name="color" value="<?php echo ($getOrderById['color']); ?>" required>
        </p>
        <p>
            <label for="unit_price">Unit Price</label>
            <input type="number" name="unit_price" value="<?php echo ($getOrderById['unit_price']); ?>" required>
        </p>
        <p>
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" value="<?php echo ($getOrderById['quantity']); ?>" required>
            <input type="submit" name="editOrderBtn" value="Update Order">
        </p>
    </form>
</body>
</html>