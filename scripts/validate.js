// Filename:  validate.js

// Function to validate the form element with the id passed as the one parameter
function Validate(id) {
    var obj = document.getElementById(id);
    var val = obj.value;
    var log_err = document.getElementById("login-error");
    var sign_err = document.getElementById("signup-error");

    if (id == "name") {
        if (val.search(/^[A-Za-z][A-Za-z ]+$/) != 0) {
            sign_err.innerHTML="Incorrect format for " + id;
            obj.style.outline="3px solid red";
            return false;
        }
        else {
            sign_err.innerHTML="";
            obj.style.outline="";
        }
    }

    if (id == "address") {
        if (val.search(/^[A-Za-z0-9][A-Za-z0-9\. ]+$/) != 0) {
            sign_err.innerHTML="Incorrect format for " + id;
            obj.style.outline="3px solid red";
            return false;
        }
        else {
            sign_err.innerHTML="";
            obj.style.outline="";
        }
    }

    if (id == "city") {
        if (val.search(/^[A-Za-z][A-Za-z\. ]+$/) != 0) {
            sign_err.innerHTML="Incorrect format for " + id;
            obj.style.outline="3px solid red";
            return false;
        }
        else {
            sign_err.innerHTML="";
            obj.style.outline="";
        }
    }

    if (id == "state") {
        if (val.search(/^[A-Za-z][A-Za-z\. ]+$/) != 0) {
            sign_err.innerHTML="Incorrect format for " + id;
            obj.style.outline="3px solid red";
            return false;
        }
        else {
            sign_err.innerHTML="";
            obj.style.outline="";
        }
    }

    if (id == "zip") {
        if (val.search(/^[0-9]*$/) != 0) {
            sign_err.innerHTML="Incorrect format for " + id;
            obj.style.outline="3px solid red";
            return false;
        }
        else {
            sign_err.innerHTML="";
            obj.style.outline="";
        }
    }

    if (id == "phone") {
        if (val.search(/^\d{3}-\d{3}-\d{4}$/) != 0) {
            sign_err.innerHTML="Incorrect format for " + id + " (###-###-####)";
            obj.style.outline="3px solid red";
            return false;
        }
        else {
            sign_err.innerHTML="";
            obj.style.outline="";
        }
    }

    if (id == "email") {
        if (val.search(/^[\w.%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/) != 0) {
            sign_err.innerHTML="Incorrect format for " + id;
            obj.style.outline="3px solid red";
            return false;
        }
        else {
            sign_err.innerHTML="";
            obj.style.outline="";
        }
    }

    // at least 6 characters, starts with letter, only numbers, letters, and underscores
    if (id == "username") {
        const status = document.getElementById('usernameFeedback');
        if (val.search(/^[A-Za-z][A-Za-z0-9_]{5,29}$/) != 0) {
            sign_err.innerHTML="Incorrect format for " + id;
            obj.style.outline="3px solid red";
            status.textContent = "";
            return false;
        }
        else {
            // Creates an XML request for non-interruptive requests
            // GOAL: Allow users to view if their desired username is 
            // available or not --> reject username when not available
            const username = document.getElementById(id).value;
            const request = new XMLHttpRequest();
            request.open('POST', 'check_username.php', true);
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Processes XML return
            request.onreadystatechange = function () {
                if (request.readyState === XMLHttpRequest.DONE) {
                    if (request.status === 200) {
                        if (request.responseText === "pass") {
                            status.textContent = "Username is available";
                            status.style.color = "green";
                            obj.style.outline="3px solid green";
                        } else if (request.responseText === "fail") {
                            status.textContent = "Username is already taken";
                            status.style.color = "red";
                            obj.style.outline="3px solid red";
                            return false;
                        }
                    } else {
                        document.getElementById('usernameFeedback').textContent = "An error occurred. Please try again.";
                        status.textContent = "";
                    }
                }
            };
            // Send username to PHP
            request.send('username=' + encodeURIComponent(username));
            sign_err.innerHTML="";
            obj.style.outline="";
        }
    }

    // at least 8 charatcers, 1 upper 1 lower, 1 digit, 1 special character
    if (id == "password") {
        if (val.search(/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/) != 0) {
            sign_err.innerHTML="Incorrect format for " + id + " (8 or more characters, at least 1 number, symbol, and uppercase)";
            obj.style.outline="3px solid red";
            return false;
        }
        else {
            sign_err.innerHTML="";
            obj.style.outline="";
        }
    }

    if (id == "password_chk") {
        var password = document.getElementById("password").value;
        var password_chk = document.getElementById(id).value;
        if (password == "" || password == null) {
            sign_err.innerHTML="Please enter a password first";
            obj.style.outline="3px solid red";
            return false;
        }
        else if (password != password_chk) {
            sign_err.innerHTML="Passwords do not match";
            obj.style.outline="3px solid red";
            return false;
        }
        else {
            sign_err.innerHTML="";
            obj.style.outline="";
        }
    }
   return true;
}

// Validation function for when the submit button is clicked.
// It works well with Internet Explorer 9, but in Firefox it sometimes allows you to submit
// a quantity that is not a number.  (However, the PHP validation on the server end catches that.)
function CheckAll()
   {
   if (Validate("name") == false)
      return false;

   if (Validate("address") == false)
      return false;

   if (Validate("city") == false)
      return false;

   if (Validate("state") == false)
      return false;

   if (Validate("zip") == false)
      return false;

   if (Validate("phone") == false)
      return false;

   if (Validate("email") == false)
      return false;

   if (Validate("username") == false)
      return false;

   if (Validate("password") == false)
    return false;

   if (Validate("password_chk") == false)
    return false;
   }
