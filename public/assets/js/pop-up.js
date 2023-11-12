$(document).ready(function () {
    // Initialize the cart count and cart array
    let cartCount = 0;
    let cart = [];

    // Use event delegation to handle click events for .film-image
    $(document).on('click', '.film-image', function () {
        var filmId = $(this).data('film-id');

        $.ajax({
            url: 'film_details.php',
            method: 'GET',
            data: { filmId: filmId },
            success: function (data) {
                console.log(data);
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

                                // Update the cart count display
                                $('#cart-count').text(cartCount);

                                // Send the filmId to add_to_cart.php
                                $.ajax({
                                    url: 'add_to_cart.php',
                                    method: 'POST',
                                    data: { filmId: filmId },
                                    success: function (response) {
                                        console.log(response); // Log the response from add_to_cart.php
                                    }
                                });

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

    $('.cart-icon').click(function () {
        window.location.href = 'cart_page.php';
    });
});
