<?php
// film_details.php

// Include your database configuration and FilmRepository classes
require_once '../includes/config.php';
require_once '../includes/classes/FilmRepository.php';

// Check if the film ID is provided via GET request
if (isset($_GET['filmId'])) {
    $filmId = $_GET['filmId'];

    // Initialize the database connection and FilmRepository
    $db = new Database();
    $filmRepository = new FilmRepository($db->getConnection());

    // Fetch film details based on the film ID using fetchFilmById
    $film = $filmRepository->fetchFilmById($filmId);

    if ($film instanceof \classes\Film) {
        // Generate HTML content for the film details
        echo '<h3>' . $film->TITRE . '</h3>';
        echo '<img src="../includes/film_images/' . $film->image . '" alt="Film Image">';
        echo '<p>Description: ' . $film->DESCRIPTION . '</p>';
        echo '<p>Price: $' . $film->PRIX . '</p>';
        echo '<p>Category: ' . $film->CATEGORY . '</p>';
    } else {
        echo 'Film not found.';
    }
} else {
    echo 'Film ID not provided.';
}
?>

