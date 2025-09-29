<?php
session_start(); // Start or resume the session

$log_username = stripslashes(trim($_POST['log_username']));
$log_password = stripslashes(trim($_POST['log_password']));
error_log("'$log_username'");
error_log("'$log_password'");

// Server-side validation of data from user input, esssential for security
$BadData = FALSE;
if (! preg_match("/^[A-Za-z][A-Za-z0-9_]{5,29}$/", $log_username))
    $BadData = TRUE;
if (! preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $log_password))
    $BadData = TRUE;

if ($BadData) {
    header("Location: signin.php?error=invalid_credentials");
    error_log("BAD DATA");
    exit();
}

$InputFile = fopen("ott.pwd", "r");
$password = fgets($InputFile, 25);   // Read up to 24 characters (so the length must be known here).
fclose($InputFile);

$host = "5.78.106.41";   // Server where the MySQL database is running (can instead use IP address).
$user = "u8112_dbPYoXqNlC";  // The user account that has access to the database.
$database = "s8112_Mantid";  // The particular database that you wish to use in MySQL.

// Procedural way to create the connection
$connection = mysqli_connect($host, $user, $password, $database);
if (!$connection) {
    error_log("Connection failure");
    exit();
} else {
    error_log("Connection success");
}

// Look for matching user credentials in database
$sql = "SELECT * FROM customers WHERE username = '$log_username' AND password = '$log_password'";
$result = mysqli_query($connection, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    error_log("user logged in");
    // Successful login actions
    mysqli_free_result($result);
    $sql = "SELECT customerID FROM customers WHERE username = '$log_username'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $customerID = $row['customerID'];

    $_SESSION['customerID'] = $customerID; // Store user session
    error_log("user logged in '$customerID'");
    header("Location: /index.php");
} else {
    // Failed login, redirect back to signin with an error
    header("Location: /signin.php?error=invalid_credentials");
}

mysqli_free_result($result);
mysqli_close($connection);    // Procedural way to close the database connection
