$(document).ready(function () {
    $('.film-image').click(function () {
        var filmId = $(this).data('film-id');
        console.log('Film image clicked. Film ID:', filmId);

        $.ajax({
            url: 'film_details.php',
            method: 'GET',
            data: { filmId: filmId },
            success: function (data) {
                console.log('AJAX response data:', data);

                // Create a basic alert to check if this part is working
                alert('Film details: ' + data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    });
});
