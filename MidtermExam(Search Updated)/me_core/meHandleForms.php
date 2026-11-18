<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors',1);
require_once 'medbConfig.php';
require_once 'meModels.php';
require_once 'meValidate.php';

if (isset($_POST['addCustomerBtn'])) {
    $added_by = $_SESSION['user_id'] ?? null; // Automatically grab logged-in user's ID

    $insert_query = insertCustomer($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['contact_number'], 
    $_POST['email'], $_POST['address'], $_POST['city'], $_POST['province'], $_POST['postal_code'], $added_by);

    if ($insert_query) {
        header("Location: ../me_sql/cs_index.php");
        exit();
    } else {
        echo "Failed To Add New Customer";
    }
}

if (isset($_POST['editCustomerBtn'])) {
    $edit_query = updateCustomer($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['contact_number'],
            $_POST['email'], $_POST['address'], $_POST['city'], $_POST['province'], $_POST['postal_code'], $_GET['customer_id']);

    if ($edit_query) {
        header("Location: ../me_sql/cs_index.php");
        exit();
    } else {
        echo "Failed to Edit Information";
    }
}

if (isset($_POST['deleteCustomerBtn'])) {
    $delete_query = deleteCustomer($pdo, $_GET['customer_id']);

    if ($delete_query) {
        header("Location: ../me_sql/cs_index.php");
        exit();
    } else {
        echo "Customer Deletion Failed.";
    }
}

if (isset($_POST['insertOrderBtn'])){
    $added_by = $_SESSION['user_id'] ?? null; // Automatically grab logged-in user's ID

    $insert_order = insertOrder($pdo, $_GET['customer_id'], $_POST['product_name'], $_POST['category'], 
        $_POST['size_code'], $_POST['color'], $_POST['unit_price'], $_POST['quantity'], $added_by);

    if ($insert_order) {
        header("Location: ../me_sql/vieworders.php?customer_id=" . $_GET['customer_id']);
        exit();
    } else {
        echo "Failed to Add Order";
    }
}

if (isset($_POST['editOrderBtn'])) {
    $edit = updateOrder($pdo, $_POST['product_name'], $_POST['category'], $_POST['size_code'], 
        $_POST['color'], $_POST['unit_price'], $_POST['quantity'], $_GET['order_id']);

    if ($edit) {
        header("Location: ../me_sql/vieworders.php?customer_id=" . $_GET['customer_id']);
        exit();
    } else {
        echo "Failed to Edit Order";
    }
}

if (isset($_POST['deleteOrderBtn'])) {
    $delete = deleteOrder($pdo, $_GET['order_id']);

    if ($delete) {
        header("Location: ../me_sql/vieworders.php?customer_id=" . $_GET['customer_id']);
        exit();
    } else {
        echo "Failed to Delete Order";
    }
}

if (isset($_POST['registerUserBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $first_name = sanitizeInput($_POST['first_name']); 
    $last_name = sanitizeInput ($_POST['last_name']);
    $password = $_POST['password'];
    $confirm_password = $_POST ['confirm_password'];

    if (!empty($username) && !empty($first_name) && !empty($last_name) && !empty($password)) {
        
        if ($password == $confirm_password) {
            if(validatePassword($password)) {
                $insertUser = insertNewUser($pdo, $username, $first_name, $last_name, sha1($password));
                if ($insertUser) {
                    header("Location: ../me_sql/login.php");
                    exit();
                } else {
                    header("Location: ../me_sql/register.php");
                    exit();
                }
            } else {
                $_SESSION['message'] = "Please make sure that the password 8 or more characters and should contain uppercase, lowercase, and numbers.";
                header("Location: ../me_sql/register.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "Please check if both passwords are equal";
            header("Location: ../me_sql/register.php");
            exit();
        }
    }
}

if (isset($_POST['loginUserBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $password = sha1($_POST['password']);
    if (!empty($username) && !empty($password)) {
        $loginUser = loginUser($pdo, $username, $password);

        if ($loginUser) {
            header("Location: ../me_sql/cs_index.php");
            exit();
        } else {
            header("Location: ../me_sql/login.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Please make sure the input fields are not empty to login";
        header("Location: ../me_sql/login.php");
        exit();
    }
}

if (isset($_GET['logoutUser'])) {
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    header("Location: ../me_sql/login.php");
    exit();
}

if (isset($_GET['searchCustomerBtn'])) {
    $searchInput = $_GET['searchInput'] ?? '';
    $searchForCustomer = searchForCustomer($pdo, $searchInput);
    
    // You can redirect back to index with results, or handle output here:
    // For now, let's ensure it outputs valid rows or handles empty sets safely:
    if (!empty($searchForCustomer)) {
        foreach ($searchForCustomer as $row) {
            echo "<tr>
            <td>{$row['customer_id']}</td>
            <td>{$row['first_name']}</td>
            <td>{$row['last_name']}</td>
            <td>{$row['contact_number']}</td>
            <td>{$row['email']}</td>
            <td>{$row['address']}</td>
            <td>{$row['city']}</td>
            <td>{$row['province']}</td>
            <td>{$row['postal_code']}</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No customers found.</td></tr>";
    }
}

if (isset($_GET['searchOrderBtn'])) {
    $searchInput = $_GET['searchInput'] ?? '';
    $customer_id = $_GET['customer_id'] ?? 0;
    
    $searchForOrder = searchForOrder($pdo, $searchInput, $customer_id);
    
    if (!empty($searchForOrder)) {
        foreach ($searchForOrder as $row) {
            echo "<tr>
            <td>{$row['order_id']}</td>
            <td>{$row['product_name']}</td>
            <td>{$row['category']}</td>
            <td>{$row['size_code']}</td>
            <td>{$row['color']}</td>
            <td>{$row['unit_price']}</td>
            <td>{$row['quantity']}</td>
            <td>{$row['customer']}</td>
            <td>{$row['added_by_user']}</td>
            <td>{$row['date_ordered']}</td>
            <td>{$row['last_updated']}</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No orders found.</td></tr>";
    }
}?>