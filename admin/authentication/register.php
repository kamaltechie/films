<?php
require_once '../../db/config.php';

class UserRegistration {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function register($username, $password) {
        $registrationError = '';

        if (empty($username) || empty($password)) {
            $registrationError = 'Les deux champs sont obligatoires!';
        } else {
            // Additional validation and security checks can be added here

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $this->connection->prepare('INSERT INTO admin (username, password) VALUES (?, ?)');
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $hashedPassword);

            if ($stmt->execute()) {
                header("Location: /films/admin/authentication/login.php");
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
    $registrationError = $userRegistration->register($_POST['username'], $_POST['password']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmMarket register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style2.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
</head>
<body>
<h2>FilmMarket</h2>

<?php if (!empty($registrationError)) : ?>
    <div class="error-message"><?php echo $registrationError; ?></div>
<?php endif; ?>

<form action="register.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <input type="submit" name="submit-btn" value="Register">
</form>
</body>
</html>
