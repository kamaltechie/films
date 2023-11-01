<?php

use classes\UserProfileUpdate;

require_once '../db/classes/UserProfileUpdate.php';
require_once '../db/config.php';

// Check if the user is logged in and get their user ID from the session
session_start();
if (!isset($_SESSION['id_client'])) {
    // Redirect to the login page or handle authentication as needed
    header("Location: authentication/login.php");
    exit();
}

// Create a new database connection
$db = new Database();

// Get the user data from the database based on the user ID (you need to implement this)
$userID = $_SESSION['id_client'];
$userData = getUserDataFromDatabase($db, $userID);

if (isset($_POST['submit-btn'])) {
    $userProfileUpdate = new UserProfileUpdate($db->getConnection());

    // Get data from the form
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $password = $_POST['password'];

    $updateResult = $userProfileUpdate->updateUserProfile($userID, $nom, $prenom, $email, $adresse, $password);

    if ($updateResult) {
        header("Location: index.php");
    } else {
        // Failed update
        // Redirect to an error page or display an error message
    }
}

// Replace this function with a database query to get user data based on the user ID
function getUserDataFromDatabase($db, $userID) {
    $stmt = $db->getConnection()->prepare('SELECT nom, prenom, email, adresse FROM client WHERE id_client = ?');
    $stmt->bindParam(1, $userID);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="assets/css/style2.css">
</head>
<body>
<?php include('partials/navbar.php'); ?>
<div id="profile-update">
    <h2>User Profile</h2>
    <form action="account.php" method="POST">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" id="nom" value="<?php echo $userData['nom']; ?>" required>
        <br>
        <label for="prenom">Prenom:</label>
        <input type="text" name="prenom" id="prenom" value="<?php echo $userData['prenom']; ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $userData['email']; ?>" required>
        <br>
        <label for="adresse">Adresse:</label>
        <input type="text" name="adresse" id="adresse" value="<?php echo $userData['adresse']; ?>" required>
        <br>
        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="password-confirm">Confirm Password:</label>
        <input type="password" name="password-confirm" id="password-confirm" required>
        <br>
        <input type="submit" name="submit-btn" value="Update Profile">
    </form>
</div>
</body>
</html>
