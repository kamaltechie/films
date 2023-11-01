<?php
include 'Film.php'; // Include the file where the class is defined

class FilmRepository {
    private $connection;

    public function __construct($db) {
        $this->connection = $db;
    }

    public function fetchFilms() {
        $films = array();

        $stmt = $this->connection->prepare("SELECT ID_FILM, TITRE, image, DESCRIPTION, PRIX, CATEGORY, STATUT FROM film");
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Instantiate the Film class with the correct namespace
            $film = new \classes\Film(
                $row['ID_FILM'],
                $row['TITRE'],
                $row['image'],
                $row['DESCRIPTION'],
                $row['PRIX'],
                $row['CATEGORY'],
                $row['STATUT']
            );
            $films[] = $film;
        }

        return $films;
    }

    public function fetchFilmById($filmId) {
        // Implement the logic to fetch a specific film by its ID
        // You should execute an SQL query to fetch the film with the given ID
        $stmt = $this->connection->prepare("SELECT ID_FILM, TITRE, image, DESCRIPTION, PRIX, CATEGORY, STATUT FROM film WHERE ID_FILM = :filmId");
        $stmt->bindParam(':filmId', $filmId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Instantiate the Film class with the correct namespace
            return new \classes\Film(
                $row['ID_FILM'],
                $row['TITRE'],
                $row['image'],
                $row['DESCRIPTION'],
                $row['PRIX'],
                $row['CATEGORY'],
                $row['STATUT']
            );
        } else {
            return null; // Film not found
        }
    }
    public function searchFilms($searchQuery) {
        $films = array();

        // Modify your SQL query to search for films based on your criteria
        $searchParam = '%' . $searchQuery . '%';  // Create a variable for the bound value
        $stmt = $this->connection->prepare("SELECT ID_FILM, TITRE, image, DESCRIPTION, PRIX, CATEGORY, STATUT FROM film WHERE TITRE LIKE :searchQuery");
        $stmt->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Instantiate the Film class with the correct namespace
            $film = new \classes\Film(
                $row['ID_FILM'],
                $row['TITRE'],
                $row['image'],
                $row['DESCRIPTION'],
                $row['PRIX'],
                $row['CATEGORY'],
                $row['STATUT']
            );
            $films[] = $film;
        }

        return $films;
    }
    public function searchFilmsByTitle($searchQuery) {
        $films = array();

        $stmt = $this->connection->prepare("SELECT ID_FILM, TITRE, image, DESCRIPTION, PRIX, CATEGORY, STATUT FROM film WHERE TITRE LIKE :search");
        $searchQuery = '%' . $searchQuery . '%';
        $stmt->bindParam(':search', $searchQuery, PDO::PARAM_STR);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Instantiate the Film class with the correct namespace
            $film = new \classes\Film(
                $row['ID_FILM'],
                $row['TITRE'],
                $row['image'],
                $row['DESCRIPTION'],
                $row['PRIX'],
                $row['CATEGORY'],
                $row['STATUT']
            );
            $films[] = $film;
        }

        return $films;
    }

}
