<?php

class UserProfileUpdate {
    private $connection;

    public function __construct($db) {
        $this->connection = $db;
    }

    public function updateUserProfile($userID, $nom, $prenom, $email, $adresse, $password) {
        // You should add validation and security checks here.

        // Hash the new password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Update the user's information in the database
        $stmt = $this->connection->prepare('UPDATE client SET nom = ?, prenom = ?, email = ?, adresse = ?, password = ? WHERE id_client = ?');
        $stmt->bindParam(1, $nom);
        $stmt->bindParam(2, $prenom);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $adresse);
        $stmt->bindParam(5, $hashedPassword);
        $stmt->bindParam(6, $userID);

        if ($stmt->execute()) {
            return true; // Update successful
        } else {
            return false; // Update failed
        }
    }
}
