<?php

// Include your database configuration or connection file
require_once '../db/config.php';

// Check if the collectionId parameter is provided
if (isset($_GET['collectionId'])) {
    $collectionId = $_GET['collectionId'];

    // Fetch collection details from the database
    $collectionDetails = getCollectionDetails($collectionId);

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($collectionDetails);
} else {
    // Handle the case where collectionId is not provided
    http_response_code(400);
    echo json_encode(['error' => 'Collection ID not provided']);
}

// Function to get collection details from the database
function getCollectionDetails($collectionId) {
    // Create a new Database instance or use your existing connection
    $db = new Database();

    // Fetch collection information
    $collectionDetailsQuery = "SELECT * FROM collection WHERE ID_COLLECTION = :collectionId";
    $collectionDetailsStmt = $db->getConnection()->prepare($collectionDetailsQuery);
    $collectionDetailsStmt->bindParam(':collectionId', $collectionId);
    $collectionDetailsStmt->execute();
    $collectionDetails = $collectionDetailsStmt->fetch(PDO::FETCH_ASSOC);

    // Fetch films associated with the collection
    $filmsQuery = "SELECT film.TITLE FROM film
                   JOIN appartient ON film.ID_FILM = appartient.ID_FILM
                   WHERE appartient.ID_COLLECTION = :collectionId";
    $filmsStmt = $db->getConnection()->prepare($filmsQuery);
    $filmsStmt->bindParam(':collectionId', $collectionId);
    $filmsStmt->execute();
    $films = $filmsStmt->fetchAll(PDO::FETCH_COLUMN);

    // Add the films to the collection details array
    $collectionDetails['FILMS'] = $films;

    return $collectionDetails;
}

?>
<?php
