$(document).ready(function () {
    // Listen to keyup events in the search input for real-time search
    $('#search').keyup(function () {
        searchFilms();
    });

    function searchFilms() {
        var searchQuery = $('#search').val().toLowerCase();

        // Hide all films initially
        $('.film').hide();

        // Make an AJAX request to the server to fetch search results
        $.ajax({
            url: 'search.php',
            method: 'POST',
            data: { searchQuery: searchQuery },
            success: function (data) {
                // Show the search results
                $('#search-results').html(data);

                // Remove the 'hide' class from matching films based on title and category
                $('.film').each(function () {
                    var filmTitle = $(this).find('h3').text().toLowerCase();
                    var filmCategory = $(this).find('p').text().toLowerCase();

                    if (filmTitle.includes(searchQuery) || filmCategory.includes(searchQuery)) {
                        $(this).show();
                    }
                });
            }
        });
    }
});
