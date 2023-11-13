<?php include('partials/navbar.php'); ?>
<?php
// Include necessary files and start the session
use classes\UserProfileUpdate;

require_once '../includes/classes/UserProfileUpdate.php';
require_once '../includes/config.php';

session_start();

// Check if the user is logged in and get their user ID from the session
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle authentication as needed
    header("Location: authentication/login.php");
    exit();
}

// Create a new database connection
$db = new Database();

// Get the user data from the database based on the user ID (you need to implement this)
$userID = $_SESSION['user_id'];
$userData = getUserDataFromDatabase($db, $userID);

// Replace this function with a database query to get user data based on the user ID
function getUserDataFromDatabase($db, $userID) {
    $stmt = $db->getConnection()->prepare('SELECT nom, prenom, email, adresse FROM client WHERE id_client = ?');
    $stmt->bindParam(1, $userID);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get the command history for the user
$commandHistory = getCommandHistory($db, $userID);

// Replace this function with a database query to get the user's command history
function getCommandHistory($db, $userID) {
    $stmt = $db->getConnection()->prepare('SELECT * FROM commande WHERE ID_CLIENT = ?');
    $stmt->bindParam(1, $userID);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle user profile update form submission
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
        // Redirect to the same page after successful update
        header("Location: account.php");
        exit();
    } else {
        // Failed update
        // Redirect to an error page or display an error message
        $updateError = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        #profile-update {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #profile-update h2 {
            color: #333;
        }



        label {
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        #command-history {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #command-history h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
        }
    </style>
</head>
<body>
<div id="profile-update">
    <h2>User Profile</h2>
    <?php if (isset($updateError) && $updateError) : ?>
        <p style="color: red;">Failed to update user profile. Please try again.</p>
    <?php endif; ?>
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
<hr>
<div id="command-history">
    <h2>Command History</h2>
    <table>
        <tr>
            <th>Command ID</th>
            <th>Date</th>
            <th>Status</th>
            <th>Total</th>
            <!-- Add more columns as needed -->
        </tr>
        <?php foreach ($commandHistory as $command) : ?>
            <tr>
                <td><?php echo $command['NUM_COM']; ?></td>
                <td><?php echo $command['DATE_COM']; ?></td>
                <td><?php echo $command['STATUT_COM']; ?></td>
                <td><?php echo $command['TOTAL']; ?></td>

            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include('partials/footer.php'); ?>
</body>
</html>
