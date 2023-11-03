<?php
session_start();

if (isset($_POST['filmId'])) {
    $filmId = $_POST['filmId'];

    // Initialize the cart array if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the film to the cart
    if (!in_array($filmId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $filmId;
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
