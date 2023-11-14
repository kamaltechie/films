<?php

use classes\CollectionRepository;
use classes\Pagination;

require_once '../includes/config.php'; // Include your database configuration file
require_once '../includes/classes/FilmRepository.php'; // Include your FilmRepository class
require_once '../includes/classes/Pagination.php'; // Include your Pagination class
require_once '../includes/classes/collectionRepository.php'; // Include your CollectionRepository class
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmMarket - Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
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
            <li><a href="#about-us">About Us</a></li>
            <li><a href="#films-section">Films</a></li>
            <li><a href="#collections">Collections</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <div class="user-info">
            <button class="cart-icon">
                Cart (<span id="cart-count">0</span>)
            </button>
            <a href="authentication/login.php" class="logout"><button class="logout">Logout</button></a>
            <a href="account.php" class="user-profile"><button class="user-profile" onclick="toggleProfileUpdate()">Profile</button></a>
        </div>
    </nav>
</header>

<!-- About Us Section -->
<section id="about-us">
    <h2>About Us</h2>

    <div id="about-store">
        <h3>Our Online Film Store</h3>
        <p>Welcome to our online film store, where your cinematic journey begins! Explore a vast collection of films ranging from classics to the latest releases. Our store is designed to provide a seamless and enjoyable experience for film enthusiasts.</p>
        <p>Discover your favorite genres, create personalized collections, and stay updated with the latest trends in the film industry. Our team is dedicated to bringing you the best in entertainment, right at your fingertips. Start your movie adventure with us!</p>
    </div>

    <hr>

    <p>some popular films at the moment : </p><br>

    <div id="film-carousel" class="carousel">

        <div class="carousel-item">FIVE NIGHTS AT FREDDY'S</div>
        <div class="carousel-item">KILLERS OF THE FLOWER MOON</div>
        <div class="carousel-item">A HAUNTING IN VENICE </div>
    </div><br>


</section>



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

<section id="films-section" class="films-section">
    <div class="film-list">
        <?php
        $db = new Database();
        $filmRepository = new FilmRepository($db->getConnection());

        // Define the number of films per row and the total number of rows
        $filmsPerRow = 4;
        $totalRows = 3;

        // Retrieve the current page number from the URL or use 1 if not specified
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Calculate the offset based on the current page
        $filmsPerPage = $filmsPerRow * $totalRows;
        $offset = ($currentPage - 1) * $filmsPerPage;

        // Fetch films from the database
        if (isset($_POST['searchQuery']) && !empty($_POST['searchQuery'])) {
            // Fetch films based on the search query
            $films = $filmRepository->searchFilmsByTitle($_POST['searchQuery']);
        } else {
            // Fetch all films from the database with pagination
            $films = $filmRepository->fetchFilmsWithPagination($filmsPerPage, $offset);
        }

        foreach ($films as $film) {
            if ($film instanceof \classes\Film) {
                echo '<div class="film">';
                echo '<img src="/film_images/' . $film->TITRE . '" alt="Film Image" class="film-image" data-film-id="' . $film->ID_FILM . '">';
                echo '<p>' . $film->CATEGORY . '</p>';
                echo '</div>';
            }
        }
        ?>
        <div class="pagination">
            <?php
            $itemsPerPage = $filmsPerPage; // Adjust the number of items per page as needed
            $totalItems = $filmRepository->getTotalFilmsCount(); // Total number of films

            $pagination = new Pagination($currentPage, $totalItems, $itemsPerPage);

            $paginationHtml = $pagination->getPaginationLinks(
                'index.php',
                isset($_POST['searchQuery']) ? ['searchQuery' => $_POST['searchQuery'] ] : []
            );

            ?>
        </div>


    </div>
    <div id="filmModal" title="Film Details" style="display: none;">
        <p id="filmDetails"></p>
        <button id="submitButton">Submit</button>
    </div>
</section>


<div>
    <?php echo $paginationHtml; ?>
</div>

<hr>
<hr>


<section id="collections">
    <h2>Collections</h2>

    <!-- Carousel of collections -->
    <div id="collections-carousel" class="carousel">
        <?php
        $collectionRepository = new CollectionRepository($db->getConnection());
        $collections = $collectionRepository->getCollectionsFromDatabase();

        foreach ($collections as $collection) {
            echo '<div class="carousel-item">';
            echo '<a href="#" onclick="showCollectionDetails(' . $collection['ID_COLLECTION'] . ')">' . $collection['NAME'] . '</a>';
            echo '</div>';
        }
        ?>
    </div>


</section>

<hr>
<hr>

</body>
</html>

<!-- Contact Us Form -->

<section id="contact" class="contact-section">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="assets/js/pop-up.js"></script>
<script src="assets/js/search.js"></script>
<script src="assets/js/ajax-pagination.js"></script>
</html>
