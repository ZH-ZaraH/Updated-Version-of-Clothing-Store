<?php
require_once '../me_core/medbConfig.php';
require_once '../me_core/meModels.php';

// 1. Validate customer_id first and sanitize it
if (!isset($_GET['customer_id']) || empty($_GET['customer_id'])) {
    header("Location: cs_index.php");
    exit();
}

$customer_id = $_GET['customer_id'];
$customerInfo = getAllInfoByCustomerId($pdo, $customer_id);
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
    
    <h1>Customer: <?php echo htmlspecialchars(($customerInfo['first_name'] ?? '') . ' ' . ($customerInfo['last_name'] ?? '')); ?></h1>
    
    <form action="vieworders.php" method="GET" style="margin-top: 20px;">
        <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer_id); ?>">
        <input type="text" name="searchInput" placeholder="Search Order" value="<?php echo htmlspecialchars($_GET['searchInput'] ?? ''); ?>">
        <input type="submit" name="searchForOrderBtn" value="Search">
        <a href="vieworders.php?customer_id=<?php echo htmlspecialchars($customer_id); ?>">Reset</a>
    </form>
    
    <h1>Add New Order</h1>
    <form action="../me_core/meHandleForms.php?customer_id=<?php echo htmlspecialchars($customer_id); ?>" method="POST">
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
        <?php 
        if (isset($_GET['searchForOrderBtn']) && !empty(trim($_GET['searchInput']))) {
            $getOrderByCustomer = searchForOrder($pdo, $_GET['searchInput'], $customer_id);
        } else {
            $getOrderByCustomer = getOrderByCustomer($pdo, $customer_id);
        }

        if (!empty($getOrderByCustomer)) {
            foreach($getOrderByCustomer as $row) { 
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['order_id'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($row['product_name'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($row['category'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($row['size_code'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($row['color'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($row['unit_price'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($row['quantity'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($row['customer'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($row['added_by'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($row['date_ordered'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($row['last_updated'] ?? ''); ?></td>
            <td>
                <a href="edit_order.php?order_id=<?php echo $row['order_id']; ?>&customer_id=<?php echo htmlspecialchars($customer_id); ?>">Edit</a> | 
                <a href="delete_order.php?order_id=<?php echo $row['order_id']; ?>&customer_id=<?php echo htmlspecialchars($customer_id); ?>">Delete</a>
            </td>
        </tr>
        <?php 
            }
        } else {
            echo "<tr><td colspan='12' style='text-align:center;'>No orders found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>