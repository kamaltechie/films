<?php
require_once '../db/config.php'; // Include your database configuration file
require_once '../db/classes/FilmRepository.php'; // Include your FilmRepository class

$db = new Database();
$filmRepository = new FilmRepository($db->getConnection());

$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$filmsPerPage = isset($_GET['filmsPerPage']) ? (int)$_GET['filmsPerPage'] : 12;
$offset = ($currentPage - 1) * $filmsPerPage;

$films = $filmRepository->fetchFilmsWithPagination($filmsPerPage, $offset);
$totalFilms = $filmRepository->getTotalFilmsCount();

$totalPages = ceil($totalFilms / $filmsPerPage);

$filmsHtml = '';
foreach ($films as $film) {
    // Generate film HTML here (similar to your original code)
}

$paginationHtml = '';
for ($page = 1; $page <= $totalPages; $page++) {
    $paginationHtml .= '<a href="#" class="' . ($page == $currentPage ? 'active' : '') . '">' . $page . '</a>';
}

$response = [
    'filmsHtml' => $filmsHtml,
    'paginationHtml' => $paginationHtml,
];

header('Content-Type: application/json');
echo json_encode($response);
