$(document).ready(function () {
    // Add a class to each film image for easier selection
    $('.film img').addClass('film-image');

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
});