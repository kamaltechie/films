<?php
require_once '../includes/config.php';
require_once '../includes/classes/FilmRepository.php';

session_start();

try {
    $db = new Database();
    $db->getConnection()->beginTransaction();

    $totalCost = 0; // Initialize total cost

    // Copy the cart to calculate total cost separately
    $cartForCalculation = $_SESSION['cart'];

    // Create a new Database instance
    $filmRepository = new FilmRepository($db->getConnection());

    // Check if any quantity changes were submitted
    if (isset($_POST['updateQuantity'])) {
        foreach ($_POST['updateQuantity'] as $filmId => $quantity) {
            // Ensure quantity is a positive integer
            $quantity = filter_var($quantity, FILTER_VALIDATE_INT);
            if ($quantity > 0) {
                $cartForCalculation[$filmId]['quantity'] = $quantity; // Adjust array structure
            }
        }
        $_SESSION['cart'] = $cartForCalculation; // Update the session cart
    }

    // Calculate the total cost
    foreach ($cartForCalculation as $item) {
        $filmId = $item['filmId'];
        $quantity = $item['quantity'];

        $film = $filmRepository->fetchFilmById($filmId);

        if ($film instanceof \classes\Film) {
            $totalCost += $film->PRIX * $quantity;
        }
    }


    $clientId = 1;
    $date = date('Y-m-d H:i:s');
    $statut = 'pending';

    $insertCommandeSQL = "INSERT INTO commande (ID_CLIENT, DATE_COM, STATUT_COM, TOTAL) VALUES (:clientId, :date, :statut, :total)";
    $insertCommandeStmt = $db->getConnection()->prepare($insertCommandeSQL);
    $insertCommandeStmt->bindParam(':clientId', $clientId);
    $insertCommandeStmt->bindParam(':date', $date);
    $insertCommandeStmt->bindParam(':statut', $statut);
    $insertCommandeStmt->bindParam(':total', $totalCost);

    if ($insertCommandeStmt->execute()) {
        // Check if there is an active transaction before committing
        if ($db->getConnection()->inTransaction()) {
            $db->getConnection()->commit();
        }

        // Clear the cart
        $_SESSION['cart'] = [];

        // Redirect to index.php
        header('Location: index.php?order=success');

        exit(); // Make sure to exit after a header redirect
    } ?> <script>

    alert('Your order has been sent!');

 </script> <?php
 {
        throw new Exception("Failed to place your order.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
