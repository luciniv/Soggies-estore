// Filename:  main.js

// Waits until entire DOM is loaded
document.addEventListener('DOMContentLoaded', function() {

    // Handles cart logic
    //  NOTE: AJAX code referenced from book materials and 
    // online resources to get functional syntax
    const shadow = document.getElementById('shadow');
    const cartButton = document.getElementById('open-cart');
    const closeCartButton = document.getElementById('close-cart');

    // Open the cart
    cartButton.addEventListener('click', () => {
        shadow.style.backgroundColor="#0035484b";
        // cart.style.right="0";
        // shadow.style.pointerEvents="all";
        window.location.href = "http://localhost:8000/cart.php";
    });

    // Close the cart
    closeCartButton.addEventListener('click', () => {
        // cart2.style.right="-340";
        // shadow.style.backgroundColor="#00354800";
        // shadow.style.pointerEvents="none";
        window.location.href = "http://localhost:8000/index.php";
    });

    // Handles adding items logic
    function AddQuantity(){
        var elements = document.querySelectorAll(".plus,.minus");
        for(var i = 0; i < elements.length; i++){
        elements[i].onclick = function(){
                let quantity = this.previousElementSibling;

            // Change innerHTML to match quantity
            if (this.classList.contains("plus")) {
                let newQuantity = parseInt(quantity.innerHTML) + 1;
                quantity.innerHTML = newQuantity;
            } else {
                quantity = this.previousElementSibling.previousElementSibling;
                let newQuantity = parseInt(quantity.innerHTML) - 1;
                if (newQuantity < 0) {
                    return;
                } else {
                    quantity.innerHTML = newQuantity;
                }
            }

            // Get associated product name and quantity, add to cart table
            let name = quantity.parentElement.parentElement.previousElementSibling.firstElementChild.innerHTML;
            let product = (name.split(" ")[0]).slice(3);
            quantity = quantity.innerHTML;
            
            // Creates an XML request for non-interruptive requests
            const request = new XMLHttpRequest();
            request.open('POST', 'build_cart.php', true);
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Processes XML return
            request.onreadystatechange = function () {
                if (request.readyState == XMLHttpRequest.DONE) {
                    if (request.status == 200 && request.readyState == 4) {
                        error_log("Cart updated successfully");
                    } else {
                        error_log("Cart failed to update");
                    }
                } else {
                    error_log("Cart failed to update");
                }
            };
            // Send product and quantity to PHP
            var data = 'product=' + encodeURIComponent(product) + '&quantity=' + encodeURIComponent(quantity);
            request.send(data);
        };
    }}
    AddQuantity();

    // Code for handling checkout procedure
    // Creates an XML request for non-interruptive requests
    const checkout = document.getElementById('checkout');
    const checkTip = document.getElementById('check-tip');
    checkout.addEventListener('click', () => {
        const request = new XMLHttpRequest();
            request.open('POST', 'checkout.php', true);
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Processes XML return, returns status of order
            request.onreadystatechange = function () {
                if (request.readyState == XMLHttpRequest.DONE) {
                    if (request.status == 200 && request.readyState == 4) {
                        if (request.responseText) {
                            checkTip.innerHTML = "Thank you! </br>Order submitted on " + request.responseText + ": NOTE orders do not have processing yet. Please see your current cart for your recipt";
                        }
                        else {
                            checkTip.innerHTML = "Error processing order";
                        }
                    }
                } else {
                    checkTip.innerHTML = "Error processing order";
                }
            };
            // Send only request to PHP
            request.send();
    })

});