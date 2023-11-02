<?php

session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
} else {
    // Initialize your database connection here (replace with your actual DB code)
    $db = new Database();
    $filmRepository = new FilmRepository($db->getConnection());

    // Retrieve film details for films in the cart
    $cartContents = $_SESSION['cart'];
    $totalCost = 0;

    echo '<table>';
    echo '<tr><th>Film Title</th><th>Price</th></tr>';

    foreach ($cartContents as $filmId) {
        $film = $filmRepository->fetchFilmById($filmId);

        if ($film instanceof \classes\Film) {
            echo '<tr>';
            echo '<td>' . $film->TITRE . '</td>';
            echo '<td>$' . $film->PRIX . '</td>';
            echo '</tr>';

            $totalCost += $film->PRIX;
        }
    }

    echo '</table>';

    echo '<p>Total Cost: $' . $totalCost . '</p>';

    // Provide an option to validate the cart
    echo '<button id="validate-cart">Validate Cart</button>';
}

?>