<!-- build_cart.php -->

<?php
session_start(); // Start or resume the session

if (!isset($_SESSION['customerID'])) {
    exit();
}

$product = stripslashes(trim($_POST['product']));
$quantity = stripslashes(trim($_POST['quantity']));
$customerID = $_SESSION['customerID'];

// Server-side validation of data from user input, esssential for security
$BadData = FALSE;
if (! preg_match("/^[A-Za-z]+$/", $product))
    $BadData = TRUE;
if (! preg_match("/^\d+$/", $quantity))
    $BadData = TRUE;

if ($BadData) {
    header("Location: index.php");
    error_log("BAD DATA");
    exit();
}

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


$sql = "SELECT * FROM cart WHERE (product_name = '$product' AND order_ID IS NULL AND customer_ID = '$customerID')";
$result = mysqli_query($connection, $sql);
error_log("'$customerID'");

if ($result && mysqli_num_rows($result) > 0) {
    // Item already in cart
    error_log("Item type already in cart");
    mysqli_free_result($result);
    if ($quantity == 0) {
        $sql = "DELETE FROM cart WHERE (product_name = '$product' AND order_ID IS NULL AND customer_ID = '$customerID');";
        $result = mysqli_query($connection, $sql);
    } else {
        $sql = "UPDATE cart SET quantity = '$quantity' WHERE (product_name = '$product' AND order_ID IS NULL AND customer_ID = '$customerID');";
        $result = mysqli_query($connection, $sql);
    }
} else {
    // Item not in cart yet
    error_log("Item type not in cart yet");
    $sql = "INSERT INTO cart (product_name, customer_ID, quantity) VALUES ('$product', '$customerID', '$quantity');";
    $result = mysqli_query($connection, $sql);
}


mysqli_close($connection);    // Procedural way to close the database connection
