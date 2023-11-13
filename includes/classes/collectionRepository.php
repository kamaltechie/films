<?php

namespace classes;

include 'Collection.php';

class CollectionRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        if (!($this->db instanceof \PDO)) {
            echo "Database connection error.";
            // Handle the error appropriately
        }
    }

    public function getCollectionsFromDatabase()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM collection");
            $collections = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $collections;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function addAction($collectionData)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO collection (NAME, DESCRIPTION, DATE_CREATION) VALUES (?, ?, ?)");
            $stmt->execute([$collectionData['NAME'], $collectionData['DESCRIPTION'], $collectionData['DATE_CREATION']]);
            return true;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function editAction($collectionData)
    {
        try {
            $stmt = $this->db->prepare("UPDATE collection SET NAME = ?, DESCRIPTION = ? WHERE ID_COLLECTION = ?");
            $stmt->execute([$collectionData['NAME'], $collectionData['DESCRIPTION'], $collectionData['ID_COLLECTION']]);
            return true;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteAction($collectionId)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM collection WHERE ID_COLLECTION = ?");
            $stmt->execute([$collectionId]);
            echo "Rows affected: " . $stmt->rowCount(); // Check if any rows were affected
            return true;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getCollectionDetailsById($collectionId)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM collection WHERE ID_COLLECTION = ?");
            $stmt->execute([$collectionId]);
            $collectionDetails = $stmt->fetch(\PDO::FETCH_ASSOC); // Adjusted here

            return $collectionDetails;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
