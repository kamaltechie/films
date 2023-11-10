<?php include('partials/navbar.php'); ?>
<?php
require_once '../db/config.php';
require_once '../db/classes/FilmRepository.php';

session_start();

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    $db = new Database();
    $filmRepository = new FilmRepository($db->getConnection());

    $totalCost = 0; // Initialize total cost

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['removeFilmId'])) {
            // If a film should be removed from the cart, remove it from the session
            $removeFilmId = $_POST['removeFilmId'];
            if (isset($cart[$removeFilmId])) {
                unset($cart[$removeFilmId]);
                $_SESSION['cart'] = $cart; // Update the session cart
            }
        }

        // Check if any quantity changes were submitted
        if (isset($_POST['updateQuantity'])) {
            foreach ($_POST['updateQuantity'] as $filmId => $quantity) {
                // Ensure quantity is a positive integer
                $quantity = filter_var($quantity, FILTER_VALIDATE_INT);
                if ($quantity > 0) {
                    $cart[$filmId] = $quantity;
                }
            }
            $_SESSION['cart'] = $cart;
        }
    }



    // Display the films in the cart along with quantity inputs and "Remove" buttons
    echo '<form method="post" action="cart_page.php">';
    echo '<table>';
    echo '<tr><th>Film Title</th><th>Price</th><th>Quantity</th><th>Total Price</th><th>Action</th></tr>';

    foreach ($cart as $filmId => $quantity) {
        $film = $filmRepository->fetchFilmById($filmId);

        if ($film instanceof \classes\Film) {
            $filmTotalPrice = $film->PRIX * $quantity;
            $totalCost += $filmTotalPrice;

            echo '<tr>';
            echo '<td>' . $film->TITRE . '</td>';
            echo '<td>$' . $film->PRIX . '</td>';
            echo '<td><input type="number" name="updateQuantity[' . $filmId . ']" value="' . $quantity . '"></td>';
            echo '<td>$' . $filmTotalPrice . '</td>';
            echo '<td>';
            echo '<button type="submit" name="removeFilmId" value="' . $filmId . '">Remove</button>';
            echo '<button type="submit" name="action" value="update">Update</button>';
            echo '</td>';
            echo '</tr>';
        }
    }

    echo '</table>';
    echo '</form>';

    // Display total cost and a button to validate the order
    echo '<p>Total Cost: $' . $totalCost . '</p>';
    echo '<form method="post" action="validate_order.php">';
    echo '<input type="submit" value="Validate Order">';
    echo '</form>';
} else {
    echo "Your cart is empty.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>


</body>
</html>
<?php include('partials/footer.php'); ?>