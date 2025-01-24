<?php
session_start(); // Start or resume the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['username']) || empty(trim($_POST['username']))) {
        exit();
    }

    $username = stripslashes(trim($_POST['username']));
    if (! preg_match("/^[A-Za-z][A-Za-z0-9_]{5,29}$/", $username)) {
        exit();
    }

    $InputFile = fopen("ott.pwd", "r");
    $password = fgets($InputFile, 25);   // Read up to 24 characters (so the length must be known here).
    fclose($InputFile);

    $host = "5.78.106.41";   // Server where the MySQL database is running (can instead use IP address).
    $user = "u8112_dbPYoXqNlC";  // The user account that has access to the database.
    $database = "s8112_Mantid";  // The particular database that you wish to use in MySQL.

    // Procedural way to create the connection (new not used):
    $connection = mysqli_connect($host, $user, $password, $database);
    if (!$connection) {
        error_log("Failed to fetch usernames");
        exit();
    } else {
        error_log("Usernames fetched");
    }

    $sql = "SELECT COUNT(*) AS total FROM customers WHERE (username = '$username');";
    $result = mysqli_query($connection, $sql);

    $row = mysqli_fetch_assoc($result);
    $count = $row['total'];
    error_log("'$count'");
    if ($count > 0) {
        echo "fail";
    } else {
        echo "pass";
    }

    mysqli_free_result($result);  // Procedural way to free up the memory
    mysqli_close($connection);    // Procedural way to close the database connection
}
