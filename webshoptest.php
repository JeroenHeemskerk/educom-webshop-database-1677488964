<?php
$servername = "localhost";
$username = "webshop_Lydia";
$password = "shoplvg";
$dbname = "lydia_webshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "INSERT INTO users (email, name, password)
VALUES ('ben@adres.nl', 'Ben', '456');";

$sql .= "INSERT INTO users (email, name, password)
VALUES ('mies@adres.nl', 'Mies', '789');";

$sql .= "SELECT name from users;";


if ($conn->multi_query($sql) === TRUE) {
    echo "Succesfully inserted or selected";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
