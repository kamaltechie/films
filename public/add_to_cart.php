<?php
session_start();

if (isset($_POST['filmId'])) {
    $filmId = $_POST['filmId'];

    // Initialize the cart array if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the filmId is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as $item) {
        if ($item['filmId'] == $filmId) {
            $found = true;
            // Increase quantity or perform any other action if needed
            break;
        }
    }

    if (!$found) {
        // Add the film to the cart as an associative array
        $_SESSION['cart'][] = ['filmId' => $filmId, 'quantity' => 1];
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
