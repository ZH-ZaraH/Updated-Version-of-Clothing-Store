<?php
# clModels.php - Handles all database CRUD operations for customers and orders

# Creating new customer in the c_customers table
function insertCustomer($pdo, $first_name, $last_name, $contact_number, $email, 
                        $address, $city, $province, $postal_code, $added_by){
    $sql = "INSERT INTO c_customers (first_name, last_name, contact_number, email, 
                                    address, city, province, postal_code, added_by)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $executeInsert = $stmt->execute([$first_name, $last_name, $contact_number, $email, 
                                    $address, $city, $province, $postal_code, $added_by]);
    if($executeInsert){
        return true;
    }
}

# Getting all records in c_customers with user join for audit tracking
function getAllCustomers($pdo) {
    $sql = "SELECT c_customers.*, users.username AS added_by_user 
            FROM c_customers 
            LEFT JOIN users ON c_customers.added_by = users.user_id";
    $stmt = $pdo->prepare($sql);
    $executeGetAll = $stmt->execute();

    if ($executeGetAll) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

# Getting records in c_customers by using the ID
function getCustomerById($pdo, $customer_id) {
    $sql = "SELECT c_customers.*, users.username AS added_by_user 
            FROM c_customers 
            LEFT JOIN users ON c_customers.added_by = users.user_id
            WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeGetId = $stmt->execute([$customer_id]);
    if ($executeGetId) {
        return $stmt->fetch();
    }
}

# Updating c_customers
function updateCustomer($pdo, $first_name, $last_name, $contact_number,
        $email, $address, $city, $province, $postal_code, $customer_id) {
        
        $sql = "UPDATE c_customers
                SET first_name = ?,
                    last_name = ?,
                    contact_number = ?,
                    email = ?,
                    address = ?,
                    city = ?,
                    province = ?,
                    postal_code = ?
                WHERE customer_id = ?";
        
        $stmt = $pdo->prepare($sql);
        $executeUpdate = $stmt->execute([$first_name, $last_name, $contact_number, 
            $email, $address, $city, $province, $postal_code, $customer_id]);
        if ($executeUpdate) {
            return true;
        }
}

# Delete Record in c_customers
function deleteCustomer($pdo, $customer_id) {
    $sql = "DELETE FROM c_customers WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeDelete = $stmt->execute([$customer_id]);
    if ($executeDelete) {
        return true;
    }
}

# Getting order by customer_id and connecting the table c_orders to c_customers and users
function getOrderByCustomer($pdo, $customer_id){
    $sql = "SELECT
                c_orders.order_id AS order_id,
                c_orders.product_name AS product_name,
                c_orders.category AS category,
                c_orders.size_code AS size_code,
                c_orders.color AS color,
                c_orders.unit_price AS unit_price,
                c_orders.quantity AS quantity,
                c_orders.date_ordered AS date_ordered,
                c_orders.last_updated AS last_updated,
                users.username AS added_by_user,
                CONCAT(c_customers.first_name,' ',c_customers.last_name) AS customer
            FROM c_orders
            JOIN c_customers ON c_orders.customer_id = c_customers.customer_id
            LEFT JOIN users ON c_orders.added_by = users.user_id
            WHERE c_orders.customer_id = ?";

    $stmt = $pdo->prepare($sql);
    $executeShow = $stmt->execute([$customer_id]);
    if ($executeShow) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

# Adding orders in c_orders
function insertOrder($pdo, $customer_id, $product_name, $category, $size_code, $color, $unit_price, $quantity, $added_by) {
    $sql = "INSERT INTO c_orders (customer_id, product_name, category, size_code, color, unit_price, quantity, added_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeAdd = $stmt->execute([$customer_id, $product_name, $category, $size_code, $color, $unit_price, $quantity, $added_by]);
    if ($executeAdd) {
        return true;
    }
}

# Getting order by order_id
function getOrderById($pdo, $order_id) {
    $sql = "SELECT
                c_orders.order_id as order_id,
                c_orders.product_name as product_name,
                c_orders.category as category,
                c_orders.size_code as size_code,
                c_orders.color as color,
                c_orders.unit_price as unit_price,
                c_orders.quantity as quantity,
                c_orders.date_ordered as date_ordered,
                users.username AS added_by_user,
                CONCAT (c_customers.first_name,' ',c_customers.last_name) AS customer
            FROM c_orders
            JOIN c_customers ON c_orders.customer_id = c_customers.customer_id
            LEFT JOIN users ON c_orders.added_by = users.user_id
            WHERE c_orders.order_id = ?";
    
    $stmt = $pdo->prepare($sql);
    $executeGet = $stmt->execute([$order_id]);
    if ($executeGet) {
        return $stmt->fetch();
    }
}

# Updating an order by order_id
function updateOrder($pdo, $product_name, $category, $size_code, $color, $unit_price, $quantity, $order_id) {
    $sql = "UPDATE c_orders
            SET product_name = ?,
                category = ?,
                size_code = ?,
                color = ?,
                unit_price = ?,
                quantity = ?
            WHERE order_id = ?";
    
    $stmt = $pdo->prepare($sql);
    $executeUpdate = $stmt->execute([$product_name, $category, $size_code, $color, $unit_price, $quantity, $order_id]);

    if ($executeUpdate) {
        return true;
    } 
}

# Deleting an order by order_id
function deleteOrder($pdo, $order_id) {
    $sql = "DELETE FROM c_orders WHERE order_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeDelete = $stmt->execute([$order_id]);
    if ($executeDelete) {
        return true;
    }
}

# See customer info by customer_id
function getAllInfoByCustomerId($pdo, $customer_id) {
    $sql = "SELECT c_customers.*, users.username AS added_by_user 
            FROM c_customers 
            LEFT JOIN users ON c_customers.added_by = users.user_id 
            WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeGet = $stmt->execute([$customer_id]);
    if ($executeGet) {
        return $stmt->fetch();
    }
}

function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
    $checkUserSql = "SELECT * FROM users WHERE username = ?";
    $checkUserSqlStmt = $pdo->prepare($checkUserSql);
    $checkUserSqlStmt->execute([$username]);

    if ($checkUserSqlStmt->rowCount() == 0) {
        $sql = "INSERT INTO users (username, first_name, last_name, password) VALUES(?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $executeInsertUser = $stmt->execute([$username,$first_name, $last_name, $password]);

        if($executeInsertUser) {
            $_SESSION['message'] = "User successfully inserted";
            return true;
        } else {
            $_SESSION['message'] = "An error occured";
        }
    } else {
        $_SESSION['message'] = "User already exists";
    }
}

function loginUser($pdo, $username, $password) {
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    if ($stmt->rowCount() == 1) {
        $userInfoRow = $stmt->fetch();
        $user_idFromDB = $userInfoRow['user_id'];
        $usernameFromDB = $userInfoRow['username'];
        $passwordFromDB = $userInfoRow['password'];

        if ($password == $passwordFromDB) {
            $_SESSION['user_id'] = $userInfoRow['user_id'];
            $_SESSION['username'] = $usernameFromDB;
            $_SESSION['message'] = "Login successful";
            return true;
        } else {
            $_SESSION['message'] = "Incorrect Password";
        }
    }

    if ($stmt->rowCount() == 0) {
        $_SESSION['message'] = "Username does not exist. Register first";
    }
}

function getAllUsers($pdo) {
    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    $executeGather = $stmt->execute();

    if ($executeGather) {
        return $stmt->fetchAll();
    }
}

function getUserById ($pdo, $user_id) {
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeGetUser = $stmt->execute([$user_id]);
    if ($executeGetUser) {
        return $stmt->fetch();
    }
}


function getCustomersByUser($pdo, $user_id) {
    $sql = "SELECT c_customers.*, users.username AS added_by_user 
            FROM c_customers 
            JOIN users ON c_customers.added_by = users.user_id 
            WHERE c_customers.added_by = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

function searchForCustomer($pdo, $searchInput) {
    $query = "SELECT c_customers.*, users.username AS added_by_user 
              FROM c_customers 
              JOIN users ON c_customers.added_by = users.user_id 
              WHERE c_customers.first_name LIKE ? 
                 OR c_customers.last_name LIKE ? 
                 OR c_customers.email LIKE ?";
    $stmt = $pdo->prepare($query);
    $searchTerm = "%" . $searchInput . "%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

# Updated search for orders restricted to a specific customer_id
function searchForOrder($pdo, $searchInput, $customer_id) {
    $query = "SELECT
                c_orders.order_id AS order_id,
                c_orders.product_name AS product_name,
                c_orders.category AS category,
                c_orders.size_code AS size_code,
                c_orders.color AS color,
                c_orders.unit_price AS unit_price,
                c_orders.quantity AS quantity,
                c_orders.date_ordered AS date_ordered,
                c_orders.last_updated AS last_updated,
                users.username AS added_by_user,
                CONCAT(c_customers.first_name,' ',c_customers.last_name) AS customer
              FROM c_orders
              JOIN c_customers ON c_orders.customer_id = c_customers.customer_id
              LEFT JOIN users ON c_orders.added_by = users.user_id
              WHERE c_orders.customer_id = ? 
                AND (c_orders.product_name LIKE ? OR c_orders.category LIKE ?)";
    
    $stmt = $pdo->prepare($query);
    $searchTerm = "%" . $searchInput . "%";
    $stmt->execute([$customer_id, $searchTerm, $searchTerm]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}