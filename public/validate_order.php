<?php

require_once '../db/config.php';
require_once '../db/classes/FilmRepository.php';

session_start();

try {
    $db = new Database();
    $db->getConnection()->beginTransaction();

    $totalCost = 0; // Initialize total cost

    // Copy the cart to calculate total cost separately
    $cartForCalculation = $_SESSION['cart'];

    // Create a new Database instance
    $db = new Database();
    $filmRepository = new FilmRepository($db->getConnection());

    // Check if any quantity changes were submitted
    if (isset($_POST['updateQuantity'])) {
        foreach ($_POST['updateQuantity'] as $filmId => $quantity) {
            // Ensure quantity is a positive integer
            $quantity = filter_var($quantity, FILTER_VALIDATE_INT);
            if ($quantity > 0) {
                $cartForCalculation[$filmId] = $quantity;
            }
        }
        $_SESSION['cart'] = $cartForCalculation; // Update the session cart
    }

    // Calculate the total cost
    foreach ($cartForCalculation as $filmId => $quantity) {
        $film = $filmRepository->fetchFilmById($filmId);

        if ($film instanceof \classes\Film) {
            $totalCost += $film->PRIX * $quantity;
        }
    }

    // Insert data into the "commande" table
    $clientId = 1; // Replace with the actual client ID
    $date = date('Y-m-d H:i:s'); // Get the current date and time
    $statut = 'pending'; // Set the default status to pending

    $insertCommandeSQL = "INSERT INTO commande (ID_CLIENT, DATE_COM, STATUT_COM, TOTAL) VALUES (:clientId, :date, :statut, :total)";
    $insertCommandeStmt = $db->getConnection()->prepare($insertCommandeSQL);
    $insertCommandeStmt->bindParam(':clientId', $clientId);
    $insertCommandeStmt->bindParam(':date', $date);
    $insertCommandeStmt->bindParam(':statut', $statut);
    $insertCommandeStmt->bindParam(':total', $totalCost);

    if ($insertCommandeStmt->execute()) {
        // Get the last insert ID within the same transaction
        $lastInsertId = $db->getConnection()->lastInsertId();

        // Insert data into the "commande_item" table
        $insertCommandeItemSQL = "INSERT INTO commande_item (NUM_COM, ID_FILM, QUANTITY) VALUES (:numCom, :filmId, :quantity)";
        $insertCommandeItemStmt = $db->getConnection()->prepare($insertCommandeItemSQL);

        foreach ($_SESSION['cart'] as $filmId => $quantity) {
    // Debugging output
    echo "Film ID in the cart: $filmId, Quantity: $quantity<br>";

    // Fetch film details
    $film = $filmRepository->fetchFilmById($filmId);

    if (!$film) {
        throw new Exception("Film with ID $filmId does not exist.");
    }


            $insertCommandeItemStmt->bindParam(':numCom', $lastInsertId);
            $insertCommandeItemStmt->bindParam(':filmId', $filmId);
            $insertCommandeItemStmt->bindParam(':quantity', $quantity);

            if (!$insertCommandeItemStmt->execute()) {
                throw new Exception("Failed to insert into commande_item. Error: " . implode(" ", $insertCommandeItemStmt->errorInfo()));
            }
        }

        $db->getConnection()->commit();

        // Display success message
        echo "Your order has been placed!";

        // Clear the cart
        $_SESSION['cart'] = [];
    } else {
        throw new Exception("Failed to place your order.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content goes here -->
</head>
<body>
<!-- Body content goes here -->
</body>
</html>

