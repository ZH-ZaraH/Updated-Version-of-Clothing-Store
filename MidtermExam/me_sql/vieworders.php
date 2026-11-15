<?php
require_once '../me_core/medbConfig.php';
require_once '../me_core/meModels.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Store - View Orders</title>
    <link rel="stylesheet" href="cs_styles.css">
</head>
<body>
    <a href="cs_index.php">Return Home</a>
    
    <?php 
    $customerInfo = getAllInfoByCustomerId($pdo, $_GET['customer_id']); 
    ?>
    <h1>Customer: <?php echo htmlspecialchars($customerInfo['first_name'] . ' ' . $customerInfo['last_name']); ?></h1>
    
    <h1>Add New Order</h1>
    <form action="../me_core/meHandleForms.php?customer_id=<?php echo $_GET['customer_id']; ?>" method="POST">
        <p>
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" required>
        </p>
        <p>
            <label for="category">Category</label>
            <input type="text" name="category" required>
        </p>
        <p>
            <label for="size_code">Size</label>
            <input type="text" name="size_code" required>
        </p>
        <p>
            <label for="color">Color</label>
            <input type="text" name="color" required>
        </p>
        <p>
            <label for="unit_price">Unit Price</label>
            <input type="number" name="unit_price" required>
        </p>
        <p>
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" value="1" required>
            <input type="submit" name="insertOrderBtn" value="Add Order">
        </p>
    </form>

    <table border="1" style="width:100%; margin-top: 50px; border-collapse: collapse;">
        <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Size</th>
            <th>Color</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Customer</th>
            <th>Added By</th>
            <th>Date Ordered</th>
            <th>Last Updated</th>
            <th>Action</th>
        </tr>
        <?php $getOrderByCustomer = getOrderByCustomer($pdo, $_GET['customer_id']); ?>
        <?php foreach($getOrderByCustomer as $row) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['order_id']); ?></td>
            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
            <td><?php echo htmlspecialchars($row['category']); ?></td>
            <td><?php echo htmlspecialchars($row['size_code']); ?></td>
            <td><?php echo htmlspecialchars($row['color']); ?></td>
            <td><?php echo htmlspecialchars($row['unit_price']); ?></td>
            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
            <td><?php echo htmlspecialchars($row['customer']); ?></td>
            <td><?php echo htmlspecialchars($row['added_by_user']); ?></td>
            <td><?php echo htmlspecialchars($row['date_ordered']); ?></td>
            <td><?php echo htmlspecialchars($row['last_updated']); ?></td>
            <td>
                <a href="edit_order.php?order_id=<?php echo $row['order_id']; ?>&customer_id=<?php echo $_GET['customer_id']; ?>">Edit</a> | 
                <a href="delete_order.php?order_id=<?php echo $row['order_id']; ?>&customer_id=<?php echo $_GET['customer_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>