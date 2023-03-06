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
            throw new Exception("No result " . mysqli_error($conn));
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
            throw new Exception("No result " . mysqli_error($conn));
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
            throw new Exception("Insert failed" . mysqli_error($conn));
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
            throw new Exception("No result " . mysqli_error($conn));
        }
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product = $row;
                array_push($products, $product);
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
