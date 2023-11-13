<?php
require_once '../../includes/config.php';

class UserRegistration {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function register($nom, $prenom, $email, $adresse, $password) {
        $registrationError = '';

        if (empty($nom) || empty($prenom) || empty($email) || empty($adresse) || empty($password)) {
            $registrationError = 'All fields are required!';
        } else {
            // Additional validation and security checks can be added here

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $this->connection->prepare('INSERT INTO client (nom, prenom, email, adresse, password) VALUES (?, ?, ?, ?, ?)');
            $stmt->bindParam(1, $nom);
            $stmt->bindParam(2, $prenom);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, $adresse);
            $stmt->bindParam(5, $hashedPassword);

            if ($stmt->execute()) {
                header("Location: login.php");
            } else {
                $registrationError = 'Registration failed.';
            }
        }

        return $registrationError;
    }
}

$registrationError = '';

if (isset($_POST['submit-btn'])) {
    $userRegistration = new UserRegistration();
    $registrationError = $userRegistration->register($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['adresse'], $_POST['password']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmMarket User Registration</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/auth.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
</head>
<body>
<h2>FilmMarket User Registration</h2>

<?php if (!empty($registrationError)) : ?>
    <div class="error-message"><?php echo $registrationError; ?></div>
<?php endif; ?>

<form action="register.php" method="POST">
    <label for="nom">Nom:</label>
    <input type="text" name="nom" id="nom" required>
    <br>
    <label for="prenom">Prenom:</label>
    <input type="text" name="prenom" id="prenom" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="adresse">Adresse:</label>
    <input type="text" name="adresse" id="adresse" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <input type="submit" name="submit-btn" value="Register">
</form>
</body>
</html>
