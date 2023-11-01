<?php
require_once '../db/config.php'; // Include your database configuration file
require_once '../db/classes/FilmRepository.php'; // Include your FilmRepository class
require_once '../db/classes/Pagination.php'; // Include your Pagination class
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmMarket - Home</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<!-- Navbar -->
<header>
    <nav>
        <div class="logo">
            <img src="assets/images/logo.jpg" alt="FilmMarket Logo">
        </div>
        <ul class="menu">
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Collections</a></li>
            <li><a href="#">Films</a></li>
            <li><a href="#">Contact us</a></li>
        </ul>
        <div class="user-info">
            <button class="cart-icon">Cart</button>
            <a href="authentication/login.php" class="logout"><button class="logout">Logout</button></a>
            <a href="account.php" class="user-profile"><button class="user-profile" onclick="toggleProfileUpdate()">Profile</button></a>
        </div>
    </nav>
</header>

<!-- Search and Picture Section -->
<section class="search-section">
    <div class="search-container">
        <div class="search-bar">
            <input type="text" name="search" id="search" placeholder="Enter keywords...">
            <button type="submit" class="search-button">search<i class="fa fa-search"></i></button>
        </div>
        <h2>Search for Enjoyable Films</h2>
    </div>

    <div class="picture">
        <img src="assets/images/films.jpg" alt="Sample Image">
    </div>
</section>




<!-- Films Section with Pagination -->
<section class="films-section">
    <div class="film-list">

        <?php

        $db = new Database();
        $filmRepository = new FilmRepository($db->getConnection());

        // Fetch films from the database
        $films = $filmRepository->fetchFilms();

        // Define the number of films per row and the total number of rows
        $filmsPerRow = 4;
        $totalRows = 3;
        $filmsCount = count($films);
        $filmsPerPage = $filmsPerRow * $totalRows;
        $totalPages = ceil($filmsCount / $filmsPerPage);

        // Retrieve the current page number from the URL or use 1 if not specified
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Calculate the offset based on the current page
        $offset = ($currentPage - 1) * $filmsPerPage;

        // Display films for the current page

        for ($i = $offset; $i < min($filmsCount, $offset + $filmsPerPage); $i++) {
        $film = $films[$i];

        if ($film instanceof \classes\Film) { // Ensure $film is an instance of Film
        echo '<div class="film">';
            echo '<h3>' . $film->TITRE . '</h3>';
            // Add a data attribute to store the film ID
            echo '<img src="../db/film_images/' . $film->image . '" alt="Film Image" class="film-image" data-film-id="' . $film->ID_FILM . '">';
            echo '<p>' . $film->CATEGORY . '</p>';
            echo '</div>';
        } else {
        echo '<p>Invalid film data</p>'; // Handle invalid data
        }
        }
        ?>
        <div class="pagination">
            <?php
            $itemsPerPage = $filmsPerPage; // Adjust the number of items per page as needed
            $totalItems = $filmsCount; // Total number of films

            $pagination = new Pagination($itemsPerPage, $totalItems);

            // Generate pagination links
            $paginationHtml = $pagination->getPaginationLinks($currentPage, 'index.php');

            echo $paginationHtml;
            ?>
        </div>
    </div>
    <div id="filmModal" title="Film Details" style="display: none;">
        <p id="filmDetails"></p>
        <button id="submitButton">Submit</button>
    </div>

</section>



</body>
</html>

<!-- Contact Us Form -->
<section class="contact-section">
    <h2>Contact Us</h2>
    <form>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Submit</button>
    </form>
</section>


<footer>
    <p>&copy; 2023 Your Website. All rights reserved.</p>
</footer>
</body>
<script src="assets/js/ajax-pagination.js"></script>
<script src="assets/js/pop-up.js"></script>
</html>
