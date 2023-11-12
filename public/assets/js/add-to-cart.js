$('.add-to-cart-button').click(function () {
    var filmId = $(this).data('film-id');

    $.ajax({
        url: 'add_to_cart.php',
        method: 'POST',
        data: { filmId: filmId },
        success: function (response) {
            // Handle the response
            console.log(response); // Log the entire response for debugging

            // Optionally, you can redirect the user to the cart page after adding to the cart
            // window.location.href = 'cart_page.php';
        }
    });
});
