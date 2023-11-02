<?php
session_start();

// Place your database connection code here

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Implement logic to save the order to the database (e.g., set order status to "processing")
    // You'll need to loop through the cart and retrieve film details

    // Clear the cart after validation
    $_SESSION['cart'] = [];

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

