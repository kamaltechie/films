<?php

namespace classes;
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
            );
            $films[] = $film;
        }

        return $films;
    }

    public function fetchFilmById($filmId) {
        // Implement the logic to fetch a specific film by its ID
        // You should execute an SQL query to fetch the film with the given ID
        $stmt = $this->connection->prepare("SELECT ID_FILM, TITRE, image, DESCRIPTION, PRIX, CATEGORY FROM film WHERE ID_FILM = :filmId");
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

            );
        } else {
            return null; // Film not found
        }
    }
    public function searchFilms($searchQuery) {
        $films = array();

        // Modify your SQL query to search for films based on your criteria
        $searchParam = '%' . $searchQuery . '%';  // Create a variable for the bound value
        $stmt = $this->connection->prepare("SELECT ID_FILM, TITRE, image, DESCRIPTION, PRIX, CATEGORY FROM film WHERE TITRE LIKE :searchQuery");
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

            );
            $films[] = $film;
        }

        return $films;
    }
    public function searchFilmsByTitle($searchQuery) {
        $films = array();

        $stmt = $this->connection->prepare("SELECT ID_FILM, TITRE, image, DESCRIPTION, PRIX, CATEGORY FROM film WHERE TITRE LIKE :search");
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

            );
            $films[] = $film;
        }

        return $films;
    }
    public function fetchFilmsWithPagination($filmsPerPage, $offset, $searchQuery = '') {
        $films = array();

        $query = "SELECT ID_FILM, TITRE, image, DESCRIPTION, PRIX, CATEGORY FROM film";

        if (!empty($searchQuery)) {
            $searchParam = '%' . $searchQuery . '%';
            $query .= " WHERE TITRE LIKE :searchQuery";
        }

        $query .= " LIMIT :offset, :filmsPerPage";

        $stmt = $this->connection->prepare($query);

        if (!empty($searchQuery)) {
            $stmt->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
        }

        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':filmsPerPage', $filmsPerPage, PDO::PARAM_INT);

        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $film = new \classes\Film(
                $row['ID_FILM'],
                $row['TITRE'],
                $row['image'],
                $row['DESCRIPTION'],
                $row['PRIX'],
                $row['CATEGORY'],
            );
            $films[] = $film;
        }

        return $films;
    }

    public function getTotalFilmsCount() {
        $query = "SELECT COUNT(*) as total FROM film";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'];
    }
    public function getFilmsFromDatabase()
    {
        try {
            $query=("SELECT * FROM film");
            $stmt= $this->connection->prepare($query);
            $stmt->execute();
            $films = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $films;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

}
