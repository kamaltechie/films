$(document).ready(function () {
    // Initialize the cart count
    let cartCount = 0;
    let cart = [];

    // Add a class to each film image for easier selection
    $('.film img').addClass('film-image');

    // When a film image is clicked, add to the cart
    $('.film-image').click(function () {
        var filmId = $(this).data('film-id');

        // Log the filmId to the console
        console.log('Adding film to cart:', filmId);

        // Fetch film details via AJAX (replace 'film_details.php' with your actual URL)
        $.ajax({
            url: 'film_details.php', // Replace with your film details URL
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

                                // Add the film to the cart (assuming it's an array)
                                cart.push(filmId);

                                // Log the updated cart to the console
                                console.log('Updated cart:', cart);

                                // Update the cart count display
                                $('#cart-count').text(cartCount);

                                // Make an AJAX request to add the film to the cart
                                $.ajax({
                                    url: 'add_to_cart.php', // Replace with your add_to_cart.php URL
                                    method: 'POST',
                                    data: { filmId: filmId },
                                    success: function (response) {
                                        if (response.success) {
                                            alert('Added to Cart');
                                        } else {
                                            alert('Failed to add to Cart');
                                        }
                                    }
                                });

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
        // Log that the cart button is clicked
        console.log('Cart button clicked');

        // Implement the logic to navigate to the cart page
        // Replace 'cart_page.php' with the actual URL of your cart page
        window.location.href = 'cart_page.php';
    });
});
