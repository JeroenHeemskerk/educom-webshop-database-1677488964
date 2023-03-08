<?php

function connectWithDB()
{

    $servername = "localhost";
    $username = "webshop_Lydia";
    $password = "shoplvg";
    $dbname = "lydia_webshop";

    // Create connection
    $conn = @mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function findUserByEmail($email)
{
    $user = NULL;
    $conn = connectWithDB();
    try {
        $sql = "SELECT * from users WHERE email='$email';";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Find user by email failed " . mysqli_error($conn));
        }
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $user = $row;
                debug_to_console($user);
            }
        }
    } finally {
        mysqli_close($conn);
    }

    return $user;
}

function findUserById($id)
{

    $user = NULL;
    $conn = connectWithDB();
    try {
        $sql = "SELECT * from users WHERE id='$id';";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Find user by id failed" . mysqli_error($conn));
        }
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $user = $row;
                debug_to_console($user);
            }
        }
    } finally {
        mysqli_close($conn);
    }

    return $user;
}

function saveUser($email, $name, $password)
{
    $conn = connectWithDB();
    try {
        $sql = "INSERT INTO users (email, name, password)
    VALUES ('$email', '$name', '$password')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Save user failed" . mysqli_error($conn));
        }
    } finally {
        mysqli_close($conn);
    }
}

function changePassword($id, $password)
{
    $conn = connectWithDB();
    try {
        $sql = "UPDATE users SET password='$password' WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Update password failed" . mysqli_error($conn));
        }
    } finally {
        mysqli_close($conn);
    }
}

function getAllProducts()
{

    $products = array();
    $conn = connectWithDB();
    try {
        $sql = "SELECT * from products;";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Get all products failed " . mysqli_error($conn));
        }
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product = $row;
                $products[$product['id']] = $product;
            }
        }
    } finally {
        mysqli_close($conn);
    }

    return $products;
}

function findProductById($productId)
{
    $conn = connectWithDB();
    $product = NULL;
    try {
        $sql = "SELECT * FROM products WHERE id = " . $productId . "";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("findProductById failed, SQL: " . $sql . "Error: " . mysqli_error($conn));
        }
        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
        }
        return $product;
    } finally {
        mysqli_close($conn);
    }
}

function saveOrder($user_id, $shoppingcartproducts)
{
    $conn = connectWithDB();
    try { // 1. insert order
        $order_nr = date("Y") . "000000";
        $sql = "INSERT INTO orders ('user_id', 'date', 'order_nr') 
    VALUES ('$user_id', CURRENT_DATE(), '$order_nr')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Save order insert userid and currentdate failed" . $sql . mysqli_error($conn));
        }

        $order_id = mysqli_insert_id($conn);

        // 2. find max ordernumber
        $sql = "SELECT max(order_nr) as max_ordernumber from orders";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("find max ordernr failed, SQL: " . $sql . "Error: " . mysqli_error($conn));
        }
        $row = mysqli_fetch_array($result);
        $maxOrderNr = $row[0];

        // 3. update current record with ordernr + 1
        $sql = "UPDATE orders SET 'order_nr' = ($maxOrderNr + 1) WHERE 'order_id' = '$order_id'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Update ordernr failed, SQL: " . $sql . "Error: " . mysqli_error($conn));
        }

        // 4. insert order products
        foreach ($shoppingcartproducts as $product) {
            $sql = "INSERT INTO order_products ('order_id', 'product_id', 'quantity')
            VALUES ('$order_id', " . $product['productId'] . "," . $product['quantity'] . ")";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                throw new Exception("Insert into order products failed, SQL: " . $sql . "Error: " . mysqli_error($conn));
            }
        }
    } finally {
        mysqli_close($conn);
    }
}
