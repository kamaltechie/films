<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart = isset($_POST['cart']) ? $_POST['cart'] : [];

    $_SESSION['cart'] = $cart;

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}