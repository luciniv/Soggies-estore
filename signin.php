<!DOCTYPE php>
<!-- signin.php -->
<html lang="en">

<head>
    <?php include 'includes/head.php'; ?>
    <title>Soggies - Sign in</title>
</head>
<!-- 
    Created by: Chloe Ott
    Date: 11/15/2024
    Last Modified: 12/10/2024
    Description: This page creates the sign-in page for website users, which can be navigated 
    to from the main page. Users may either sign up or log in depending on if they have an 
    account already made. XML requests allow users to verify whether their selected 
    username has been taken or not. Hints to potentially uncover passwords are not provided. 
    The security for this page runs form input through an initial javascript check. Further
    examination is completed with PHP on the backend (ensures client-side tampering does
    not make its way into databases / backend code).
    -->

<body class="helvetica">
    <?php include 'includes/nav.php'; ?>
    <div id="customer-portal">
        <h1><b>Customer Portal</b></h1>
        <h2><em>New and returning customers, sign in here!</em></h2>
        <div id="forms">
            <div id="login-f">
                <div id="login-form">
                    <h3><b>Log in</b></h3>
                    <form action="login_validate.php" method="post">
                        <input type="text" name="log_username" id="log_username" size="20" placeholder="Username" required /></br>
                        <input type="password" name="log_password" id="log_password" size="20" placeholder="Password" required /></br>
                        <input type="submit" value="Log in"></br>
                        <span id="login-error">
                            <?php
                            // Check if error is set
                            if (isset($_GET['error'])) {
                                // Display a message based on the error type
                                if ($_GET['error'] == 'invalid_credentials') {
                                    echo "Username or password is incorrect";
                                }
                            }
                            ?>
                        </span>
                    </form>
                </div>
                <div id="tips">
                </div>
            </div>
            <div id="signup-form">
                <h3><b>Sign up</b></h3>
                <form action="signup_validate.php" method="post">
                    <input type="text" name="name" id="name" size="20" placeholder="Full name" onchange='Validate("name");' required /></br>
                    <input type="text" name="address" id="address" size="20" placeholder="Address" onchange='Validate("address");' required />
                    <input type="text" name="city" id="city" size="20" placeholder="City" onchange='Validate("city");' required />
                    <input type="text" name="state" id="state" size="15" placeholder="State" onchange='Validate("state");' required />
                    <input type="text" name="zip" id="zip" size="6" placeholder="Zip" onchange='Validate("zip");' required /></br>
                    <input type="text" name="phone" id="phone" size="12" placeholder="Phone number" onchange='Validate("phone");' required />
                    <input type="text" name="email" id="email" size="20" placeholder="Email" onchange='Validate("email");' required /></br></br>
                    <input type="text" name="username" id="username" size="20" placeholder="Username" onchange='Validate("username");' required /><span id="usernameFeedback"></span></br>
                    <input type="password" name="password" id="password" size="20" placeholder="Password" onchange='Validate("password");' required />
                    <input type="password" name="password_chk" id="password_chk" size="20" placeholder="Verify password" onchange='Validate("password_chk");' required /></br>
                    <input type="submit" value="Sign up" onClick='return CheckAll();'></br>
                    <span id="signup-error"></span>
                </form>
            </div>
        </div>
    </div>
    <img id="portal-img" src="assets/ducks_bg.jpg" width="100%" alt="Ducks banner" />
    <script src="scripts/validate.js"></script>
</body>

</html>