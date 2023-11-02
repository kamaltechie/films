$(document).ready(function () {
    // Initialize the cart count
    let cartCount = 0;

    // Add a class to each film image for easier selection
    $('.film img').addClass('film-image');

    // When a film image is clicked, add to the cart
    $('.film-image').click(function () {
        var filmId = $(this).data('film-id');

        // Fetch film details via AJAX (replace 'film_details.php' with your actual URL)
        $.ajax({
            url: 'film_details.php',
            method: 'GET',
            data: { filmId: filmId },
            success: function (data) {
                // Create a dialog element with film details
                var $filmDialog = $('<div></div>')
                    .html(data)
                    .dialog({
                        width: 400, // Set the desired width
                        modal: true,
                        buttons: {
                            "Add to Cart": function () {
                                // Increment the cart count
                                cartCount++;
                                // Update the cart count display
                                $('#cart-count').text(cartCount);
                                // Implement the action to add the film to the cart here
                                // You can use another AJAX request to add the film to the cart
                                alert('Added to Cart'); // Replace with your actual cart logic
                                $(this).dialog("close");
                            },
                            "Close": function () {
                                $(this).dialog("close");
                            }
                        },
                        close: function () {
                            $(this).dialog("destroy").remove();
                        }
                    });
            }
        });
    });

    // When the Cart button is clicked, take the user to the cart page
    $('.cart-icon').click(function () {
        // Implement the logic to navigate to the cart page
        // Replace 'cart_page.php' with the actual URL of your cart page
        window.location.href = 'cart_page.php';
    });
});
// Handle cart validation
$('#validate-cart').click(function () {
    $.ajax({
        url: 'validate_cart.php',
        method: 'POST',
        success: function (data) {
            if (data.success) {
                // Cart successfully validated
                alert('Your order has been placed!');
                // Clear the cart and update the cart count
                cartCount = 0;
                $('#cart-count').text(cartCount);
            } else {
                alert('Failed to validate your cart.');
            }
        }
    });
});


