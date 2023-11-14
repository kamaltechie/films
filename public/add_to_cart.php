<?php

session_start();
$_SESSION['test'] = 'Hello, World!';
echo 'Session set.';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filmId = $_POST['filmId'];

    // Initialize the cart array if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the filmId is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['filmId'] == $filmId) {
            $found = true;
            // Increase quantity or perform any other action if needed
            $_SESSION['cart'][$key]['quantity'] += 1;
            break;
        }
    }

    if (!$found) {
        // Add the film to the cart as an associative array
        $_SESSION['cart'][] = ['filmId' => $filmId, 'quantity' => 1];
    }

    $response = ['success' => true, 'cart' => $_SESSION['cart']];
    echo json_encode($response);
    var_dump($_SESSION['cart']);
} else {
    echo json_encode(['success' => false]);
}
?>
