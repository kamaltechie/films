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
}

