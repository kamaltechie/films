<?php

namespace classes;

class ClientRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getClientsFromDatabase()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM client");
            $clients = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $clients;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function addAction($clientData)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO client (NOM, PRENOM, EMAIL, ADRESSE, PASSWORD) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$clientData['NOM'], $clientData['PRENOM'], $clientData['EMAIL'], $clientData['ADRESSE'], $clientData['PASSWORD']]);
            return true;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function editAction($clientData)
    {
        try {
            $stmt = $this->db->prepare("UPDATE client SET NOM = ?, PRENOM = ?, EMAIL = ?, ADRESSE = ? WHERE ID_CLIENT = ?");
            $stmt->execute([$clientData['NOM'], $clientData['PRENOM'], $clientData['EMAIL'], $clientData['ADRESSE'], $clientData['ID_CLIENT']]);
            return true;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteAction($clientId)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM client WHERE ID_CLIENT = ?");
            $stmt->execute([$clientId]);
            return true;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
