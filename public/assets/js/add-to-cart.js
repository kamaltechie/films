$('.add-to-cart-button').click(function () {
    var filmId = $(this).data('film-id');

    $.ajax({
        url: 'add_to_cart.php',
        method: 'POST',
        data: { filmId: filmId },
        success: function (response) {
            // Handle the response (e.g., update the cart count display)
        }
    });
});
