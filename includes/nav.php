<?php
session_start(); // Start or resume the session

echo
"<nav>
    <div id='logo'>
        <a class='nunito-heavy' href='index.html'>Soggies</a><img src='assets/logo.png' alt='Soggies' width='29' height='27'>
    </div>
    <div id='navigation'>
        <ul>
            <li><a href='index.php'><b>About</b></a></li>
            <li><a href='index.php'><b>Ducks</b></a></li>
            <li><a href='index.php'><b>Geese</b></a></li>
            <li><a href='index.php'><b>Swans</b></a></li>
            <li><a href='index.php'><b>Accessories</b></a></li>
        </ul>
    </div>
    <div id='login'>
        <ul>
            <li><a href='index.php'><b>Contact us</b></a></li>";


// Check if the session variable for customerID is set
if (!isset($_SESSION['customerID']) || empty($_SESSION['customerID'])) {
    echo "<li><a href='signin.php'><b>Log in</b></a></li>
        </ul>
    </div>
</nav>";
} else {
    echo "<li id='open-cart'><b>Your Cart</b></li>
        </ul>
        <img src='assets/cart.svg' alt='Your Cart' width='28' height='28'>
    </div>
</nav>";
}
