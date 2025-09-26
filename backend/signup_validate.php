<?php
session_start(); // Start or resume the session

$name = stripslashes(trim($_POST['name']));
$address = stripslashes(trim($_POST['address']));
$city = stripslashes(trim($_POST['city']));
$state = stripslashes(trim($_POST['state']));
$zip = stripslashes(trim($_POST['zip']));
$phone = stripslashes(trim($_POST['phone']));
$email = stripslashes(trim($_POST['email']));
$sign_username = stripslashes(trim($_POST['username']));
$sign_password = stripslashes(trim($_POST['password']));
$sign_password_chk = stripslashes(trim($_POST['password_chk']));

// Server-side validation of data from user input, esssential for security
$BadData = FALSE;
if (! preg_match("/^[A-Za-z][A-Za-z ]+$/", $name))
    $BadData = TRUE;
if (! preg_match("/^[A-Za-z0-9][A-Za-z0-9\. ]+$/", $address))
    $BadData = TRUE;
if (! preg_match("/^[A-Za-z][A-Za-z\. ]+$/", $city))
    $BadData = TRUE;
if (! preg_match("/^[A-Za-z][A-Za-z\. ]+$/", $state))
    $BadData = TRUE;
if (! preg_match("/^[0-9]*$/", $zip))
    $BadData = TRUE;
if (! preg_match("/^\d{3}-\d{3}-\d{4}$/", $phone))
    $BadData = TRUE;
if (! preg_match("/^[\w.%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/", $email))
    $BadData = TRUE;
if (! preg_match("/^[A-Za-z][A-Za-z0-9_]{5,29}$/", $sign_username))
    $BadData = TRUE;
if (! preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $sign_password))
    $BadData = TRUE;

if ($BadData) {
    error_log("BAD DATA");
    exit();
}

$InputFile = fopen("ott.pwd", "r");
$password = fgets($InputFile, 25);   // Read up to 24 characters
fclose($InputFile);

$host = "5.78.106.41";
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

// Insert customer into customers table
$sql = "INSERT INTO customers (customer_name,address,city,state,zip_code,phone,email,username,password) VALUES ('$name','$address','$city','$state','$zip','$phone','$email','$sign_username','$sign_password');";
$result = mysqli_query($connection, $sql);  // Procedural style of running the SQL query

// Store session
$sql = "SELECT customerID FROM customers WHERE username = '$sign_username'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
$customerID = $row['customerID'];
$_SESSION['customerID'] = $customerID; // Store user session
error_log("'$customerID'");

mysqli_close($connection);    // Procedural way to close the database connection
header("Location: index.php");
