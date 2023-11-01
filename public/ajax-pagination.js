$(document).ready(function () {
    const filmsPerPage = 12; // Number of films to display per page
    let currentPage = 1;

    function loadFilms(page) {
        $.ajax({
            url: 'film_data.php',
            method: 'GET',
            data: { page: page, filmsPerPage: filmsPerPage },
            success: function (data) {
                $('.film-list').html(data.filmsHtml);
                $('.pagination').html(data.paginationHtml);
            },
            error: function () {
                alert('Failed to load films.');
            }
        });
    }

    loadFilms(currentPage);

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        currentPage = $(this).text();
        loadFilms(currentPage);
    });
});
