<?php
require '../../db/config.php';
include_once '../../db/classes/CommandeRepository.php';

// Verifica se la richiesta è una richiesta AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $database = new Database();
    $connection = $database->getConnection();
    $commandeRepository = new classes\CommandeRepository($connection);

    $action = $_POST['action'];

    // Chiamare la funzione appropriata in base all'azione
    switch ($action) {
        case 'acceptCommande':
            if (isset($_POST['numCom'])) {
                $numCom = $_POST['numCom'];
                $commandeRepository->acceptCommande($numCom);
            } else {
                echo 'failure'; // Manca il parametro numCom
            }
            break;

        case 'refuseCommande':
            if (isset($_POST['numCom'])) {
                $numCom = $_POST['numCom'];
                $commandeRepository->refuseCommande($numCom);
            } else {
                echo 'failure'; // Manca il parametro numCom
            }
            break;

        case 'deleteCommande':
            if (isset($_POST['numCom'])) {
                $numCom = $_POST['numCom'];
                $commandeRepository->deleteCommande($numCom);
            } else {
                echo 'failure'; // Manca il parametro numCom
            }
            break;

        default:
            echo 'failure'; // Azione non supportata
            break;
    }
} else {
    echo 'failure'; // Richiesta non valida
}
?>
