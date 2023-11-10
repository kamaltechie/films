<?php

include 'Collection.php';
class CollectionRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getCollectionsFromDatabase() {
        try {
            $stmt = $this->db->query("SELECT * FROM collection");
            $collections = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $collections;
        } catch (PDOException $e) {
            // Handle database connection or query error
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}

?>