<?php
// Include your database configuration and FilmRepository classes
require_once '../db/config.php';
require_once '../db/classes/FilmRepository.php';

// Check if the search query is provided via POST request
if (isset($_POST['searchQuery'])) {
    $searchQuery = $_POST['searchQuery'];

    // Initialize the database connection and FilmRepository
    $db = new Database();
    $filmRepository = new FilmRepository($db->getConnection());

    // Fetch films based on the search query for the title
    $films = $filmRepository->searchFilmsByTitle($searchQuery);

    // Generate HTML content for the search results
    if (!empty($films)) {
        foreach ($films as $film) {
            echo '<div class="film">';
            echo '<h3>' . $film->TITRE . '</h3>';
            echo '<img src="../db/film_images/' . $film->image . '" alt="Film Image">';
            echo '<p>' . $film->CATEGORY . '</p>';
            echo '</div>';
        }
    } else {
        echo 'No results found.';
    }
}
?>
