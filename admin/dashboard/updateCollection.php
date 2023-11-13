<?php

require '../../includes/config.php';
include_once '../../includes/classes/CollectionRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $connection = $database->getConnection();
    $collectionRepository = new classes\CollectionRepository($connection);

    // Get form data
    $collectionData = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'description' => $_POST['description'],
    ];

    // Update the collection
    if ($collectionRepository->editAction($collectionData)) {
        echo 'success'; // Update successful
    } else {
        echo 'failure'; // Update failed
    }
} else {
    echo 'Invalid request method.';
}

