<?php
require '../../includes/config.php';
include_once '../../includes/classes/CommandeRepository.php';
include_once '../../includes/classes/CollectionRepository.php';

// Check if the request is an AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $database = new Database();
    $connection = $database->getConnection();
    $commandeRepository = new classes\CommandeRepository($connection);
    $collectionRepository = new classes\CollectionRepository($connection);

    $action = $_POST['action'];

    // Call the appropriate function based on the action
    switch ($action) {
        case 'acceptCommande':
            if (isset($_POST['numCom'])) {
                $numCom = $_POST['numCom'];
                $commandeRepository->acceptCommande($numCom);
            } else {
                echo 'failure'; // Missing numCom parameter
            }
            break;

        case 'refuseCommande':
            if (isset($_POST['numCom'])) {
                $numCom = $_POST['numCom'];
                $commandeRepository->refuseCommande($numCom);
            } else {
                echo 'failure'; // Missing numCom parameter
            }
            break;

        case 'deleteCommande':
            if (isset($_POST['numCom'])) {
                $numCom = $_POST['numCom'];
                $commandeRepository->deleteCommande($numCom);
            } else {
                echo 'failure';
            }
            break;

        case 'addAction': // Add this case for handling collection actions
            if (isset($_POST['collectionData'])) {
                $collectionData = $_POST['collectionData'];
                $result = $collectionRepository->addAction($collectionData);
                echo $result ? 'success' : 'failure';
            } else {
                echo 'failure';
            }
            break;

        case 'editAction':
            if (isset($_POST['collectionData'])) {
                $collectionData = $_POST['collectionData'];
                $result = $collectionRepository->editAction($collectionData);
                echo $result ? 'success' : 'failure';
            } else {
                echo 'failure';
            }
            break;

        case 'deleteAction':
            if (isset($_POST['collectionData'])) {
                $collectionData = $_POST['collectionData'];
                $result = $collectionRepository->deleteAction($collectionData);
                echo $result ? 'success' : 'failure';
            } else {
                echo 'failure';
            }
            break;

        default:
            echo 'failure';
            break;
    }
} else {
    echo 'failure';
}
?>
