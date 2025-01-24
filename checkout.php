<?php
session_start(); // Start or resume the session

$customerID = $_SESSION['customerID'];

$InputFile = fopen("ott.pwd", "r");
$password = fgets($InputFile, 25);   // Read up to 24 characters 
fclose($InputFile);

$host = "5.78.106.41";   // Server where the MySQL database is running 
$user = "u8112_dbPYoXqNlC";  // The user account that has access to the database
$database = "s8112_Mantid";  // The particular database that you wish to use in MySQL

// Procedural way to create the connection (new not used):
$connection = mysqli_connect($host, $user, $password, $database);
if (!$connection) {
    error_log("Connection failure");
    exit();
} else {
    error_log("Connection success");
}

$timestamp = time();
$currentDate = gmdate('Y-m-d H-i-s', $timestamp);

// Insert order data into database
$sql = "INSERT INTO orders (customer_ID, order_date) VALUES ('$customerID', '$currentDate');";
$result = mysqli_query($connection, $sql);
$orderNum = mysqli_insert_id($connection);

// Update cart table items by connecting them to their order number
$sql = "UPDATE cart SET order_ID = '$orderNum' WHERE (customer_ID = '$customerID');";
$result = mysqli_query($connection, $sql);

echo "'$currentDate'";

mysqli_close($connection);    // Procedural way to close the database connection
