<?php
require_once '../db/config.php';
require_once '../db/classes/FilmRepository.php';

// Create a new Database connection
$db = new Database();
$filmRepository = new FilmRepository($db->getConnection());

// Get the current page from the URL or default to page 1
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Define the number of films to display per page
$filmsPerPage = 12;

// Calculate the offset for the current page
$offset = ($currentPage - 1) * $filmsPerPage;

// Retrieve the search query from the request
$searchQuery = isset($_POST['searchQuery']) ? $_POST['searchQuery'] : '';

// Fetch films based on the search query with pagination
$films = $filmRepository->fetchFilmsWithPagination($filmsPerPage, $offset, $searchQuery);

// Calculate the total number of films
$totalFilms = $filmRepository->getTotalFilmsCount();

// Calculate the total number of pages
$totalPages = ceil($totalFilms / $filmsPerPage);

$filmsHtml = '';

// Loop through the retrieved films and generate HTML
foreach ($films as $film) {
    $filmsHtml .= '<div class="film">';
    $filmsHtml .= '<h3>' . $film->TITRE . '</h3>';
    $filmsHtml .= '<img src="../db/film_images/' . $film->image . '" alt="Film Image" class="film-image" data-film-id="' . $film->ID_FILM . '">';
    $filmsHtml .= '<p>' . $film->CATEGORY . '</p>';
    $filmsHtml .= '</div>';
}

$paginationHtml = '';

// Generate pagination links
for ($page = 1; $page <= $totalPages; $page++) {
    $paginationHtml .= '<a href="#" class="' . ($page == $currentPage ? 'active' : '') . '">' . $page . '</a>';
}

$response = [
    'filmsHtml' => $filmsHtml,
    'paginationHtml' => $paginationHtml,
];

header('Content-Type: application/json');
echo json_encode($response);
?>
