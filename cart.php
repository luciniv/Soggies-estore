<!DOCTYPE php>
<!-- index.php -->
<html lang="en">

<head>
    <?php include 'includes/head.php'; ?>
    <title>Soggies - Your Cart</title>
</head>
<!-- 
    Created by: Chloe Ott
    Date: 11/15/2024
    Last Modified: 12/10/2024
    Description: Copy of index.php, used to display the cart. I attempted
    to set up XML requests to update the cart without refreshing the page,
    but overall I did not have enough time to commit to it beyond other finals.
    This page simply allows the user to refresh every time they click onto
    or off of the cart (without having to manually refresh).

    NOTE: A more streamlined system would implement AJAX or something
    similar to handle the cart. 
    -->

<body class="helvetica">
    <?php include 'includes/nav.php'; ?>
    <div id="shadow2"></div>
    <div id="cart2">
        <div id="cart-head">
            <span><b>Cart</b></span>
            <img src='assets/cart.svg' alt='Your Cart' width='28' height='28'>
            <img id="close-cart" src='assets/x.svg' alt='Close Cart' width='23' height='23'>
        </div>
        <div id="cart-body">
            <?php
            $InputFile = fopen("ott.pwd", "r");
            $password = fgets($InputFile, 25);   // Read up to 24 characters 
            fclose($InputFile);

            $host = "5.78.106.41";   // Server where the MySQL database is running
            $user = "u8112_dbPYoXqNlC";  // The user account that has access to the database
            $database = "s8112_Mantid";  // The particular database that you wish to use in MySQL

            // Procedural way to create the connection (new not used):
            $connection = mysqli_connect($host, $user, $password, $database);
            if (!$connection) {
                error_log("Failed to fetch products");
                exit();
            } else {
                error_log("Products fetched");
            }

            // Initial update of the cart
            $total = 0;
            $customerID = $_SESSION['customerID'];
            $sql = "SELECT products.image_url, products.product_name, products.product_type, products.price, cart.quantity FROM products INNER JOIN cart ON cart.product_name = products.product_name WHERE (cart.customer_ID = '$customerID' AND cart.order_ID IS NULL);";
            $result = mysqli_query($connection, $sql);  // Procedural style of running the SQL query

            if (! $result) {
                error_log("No products found");
                exit();
            }

            $NumRows = mysqli_num_rows($result);   // Procedural way to look up the number of rows of data

            if ($NumRows == 0) {
                echo "<div id='empty'><b>Your cart is empty!</b></div>";
            } else {
                while ($row = mysqli_fetch_assoc($result))  // Process 1 row at a time from the result object.
                {
                    $image = $row['image_url'];
                    $name = $row['product_name'];
                    $type = $row['product_type'];
                    $price = $row['price'];
                    $format_price = number_format($price, 2, '.', ',');
                    $quantity = $row['quantity'];

                    echo "<div class='cart-item'>";
                    echo "<img src='assets/" . $image . "' alt='Product' width='144'>";
                    echo "<div class='cart-details'><div class='product-info'>";
                    echo "<span class='name'><b>" . $name . " " . $type . "</b></span></div>";
                    echo "<div class='product-interact'><span class='price'><b>$" . $format_price . "</b></span>";
                    echo "<div class='button'><div class='quantity'>" . $quantity . "</div>";
                    echo "<div class='plus'><img src='assets/plus.svg' width='15' height='15' alt='Add item'></div>";
                    echo "<div class='minus'><img src='assets/minus.svg' width='15' height='15' alt='Remove item'></div>";
                    echo "</div></div></div></div>";

                    $total = $total + ($price * $quantity);
                    $format_total = number_format($total, 2, '.', ',');
                }

                echo "</div><div id='cart-foot'>";
                echo "<div id='subtotal'><span><b>Subtotal: $" . $format_total . "</b></span></div>";
                echo "<div id='checkout'><span><b>Checkout</b></span>";
                echo "<img src='assets/arrow.svg' alt='Checkout' width='50'></br>";
                echo "</div><div id='check-tip'></div>";

                mysqli_free_result($result);  // Procedural way to free up the memory
                mysqli_close($connection);    // Procedural way to close the database connection
            }
            ?>
        </div>
    </div>

    <div id="hero">
        <img src="assets/hero.png" alt="Geese, Ducks & Swans" width="100%">
        <div id="hero-text">
            <span><b>New breeds every Spring</b></span>
            <?php
            // Check if the session variable for customerID is set
            if (!isset($_SESSION['customerID']) || empty($_SESSION['customerID'])) {
                echo "<a href='signin.php'>
                        <div id='button'><b>Sign up / Log in to start shopping!</b></div>
                        </a>";
            } else {
                echo "<a href='index.php'>
                        <div id='button'><b>Keep scrolling to shop our latest birds!</b></div>
                        </a>";
            }
            ?>
        </div>
    </div>
    <div id="banner">
        <em><b>Spring 2025 pre-orders are available! Use code “PUDDLES” at checkout for 15% of all orders</b></em>
    </div>
    <div id="main">
        <div id="filter">
            <span><b>Filter Items</b></span>
            <div id="divider"></div>
            <div>Filtering feature coming soon!</div>
        </div>
        <div id="store">
            <?php
            $InputFile = fopen("ott.pwd", "r");
            $password = fgets($InputFile, 25);   // Read up to 24 characters
            fclose($InputFile);

            $host = "5.78.106.41";   // Server where the MySQL database is running
            $user = "u8112_dbPYoXqNlC";  // The user account that has access to the database
            $database = "s8112_Mantid";  // The particular database that you wish to use in MySQL

            // Procedural way to create the connection (new not used):
            $connection = mysqli_connect($host, $user, $password, $database);
            if (!$connection) {
                error_log("Failed to fetch products");
                exit();
            } else {
                error_log("Products fetched");
            }
            // Get everything from the products table
            $sql = 'SELECT * FROM products;';
            $result = mysqli_query($connection, $sql);  // Procedural style of running the SQL query

            if (! $result) {
                error_log("No products found");
                exit();
            }
            $NumRows = mysqli_num_rows($result);   // Procedural way to look up the number of rows of data

            if ($NumRows == 0) {
                error_log("No products available");
            } else {
                while ($row = mysqli_fetch_assoc($result))  // Process 1 row at a time from the result object
                {
                    $image = $row['image_url'];
                    $status = $row['product_status'];
                    $name = $row['product_name'];
                    $type = $row['product_type'];
                    $detail = $row['product_detail'];
                    $price = $row['price'];
                    $format_price = number_format($price, 2, '.', ',');
                    $quantity = 0;

                    // Create each product element
                    echo "<div class='product'>";
                    echo "<div class='product-status'><b>" . $status . "</b></div>";
                    echo "<div class='product-image'><img src='assets/" . $image . "' alt='Product' width='100%'></div>";
                    echo "<div class='product-text'><div class='product-info'>";
                    echo "<span class='name'><b>" . $name . " " . $type . "</b></span><span class='detail'><em>" . $detail . "</em></span></div>";
                    echo "<div class='product-interact'><span class='price'><b>$" . $format_price . "</b></span>";

                    // Determination path for quantity, WILL SAVE ACROSS REFRESHES
                    if (!isset($_SESSION['customerID']) || empty($_SESSION['customerID'])) {
                        echo "<div class='button'><div class='quantity'>" . $quantity . "</div>";
                    } else {
                        $ID = $_SESSION['customerID'];
                        $sql = "SELECT quantity FROM cart WHERE (product_name = '$name' AND order_ID IS NULL AND customer_ID = '$ID');";
                        $quantity_result = mysqli_query($connection, $sql);  // Procedural style of running the SQL query

                        // Runs if a quantity has been found, else display zero
                        if ($quantity_result && mysqli_num_rows($quantity_result) > 0) {
                            $quantity_row = mysqli_fetch_assoc($quantity_result);
                            $quantity = $quantity_row['quantity'];
                            error_log("heres what quantity is, if its not nothing'$quantity'");
                            if (!($quantity > 0) || $quantity == NULL) {
                                $quantity = 0;
                                echo "<div class='button'><div class='quantity'>" . $quantity . "</div>";
                            } else {
                                echo "<div class='button'><div class='quantity'>" . $quantity . "</div>";
                            }
                        } else {
                            echo "<div class='button'><div class='quantity'>" . $quantity . "</div>";
                        }
                    }
                    echo "<div class='plus'><img src='assets/plus.svg' width='15' height='15' alt='Add item'></div>";
                    echo "<div class='minus'><img src='assets/minus.svg' width='15' height='15' alt='Remove item'></div>";
                    echo "</div></div></div></div>";
                }
                mysqli_free_result($result);  // Procedural way to free up the memory
                mysqli_close($connection);    // Procedural way to close the database connection
            }
            ?>
        </div>
    </div>
    <script src="scripts/main.js"></script>
</body>

</html>