<?php
require_once 'Film.php'; // Make sure to include your Film class definition

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
        $stmt = $this->connection->prepare("SELECT ID_FILM, TITRE, image, DESCRIPTION, PRIX, CATEGORY FROM film WHERE ID_FILM = :filmId");
        $stmt->bindParam(':filmId', $filmId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
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
        $searchParam = '%' . $searchQuery . '%';

        $stmt = $this->connection->prepare("SELECT ID_FILM, TITRE, image, DESCRIPTION, PRIX, CATEGORY FROM film WHERE TITRE LIKE :searchQuery");
        $stmt->bindParam(':searchQuery', $searchParam, PDO::PARAM_STR);
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

    public function searchFilmsByTitle($searchQuery) {
        $films = array();
        $searchQuery = '%' . $searchQuery . '%';

        $stmt = $this->connection->prepare("SELECT ID_FILM, TITRE, image, DESCRIPTION, PRIX, CATEGORY FROM film WHERE TITRE LIKE :search");
        $stmt->bindParam(':search', $searchQuery, PDO::PARAM_STR);
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
            $stmt = $this->connection->query("SELECT * FROM film");
            $films = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $films;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
?>
