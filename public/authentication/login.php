<?php
require_once '../../includes/config.php';

class UserAuthentication {
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function login($email, $password) {
        $loginError = '';

        if (empty($email) || empty($password)) {
            $loginError = 'Both email and password are required.';
        }

        if (!$loginError) {
            $stmt = $this->connection->prepare('SELECT id_client, password FROM client WHERE email = ?');
            $stmt->bindParam(1, $email);

            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($result) > 0 && password_verify($password, $result[0]['password'])) {
                    session_start();
                    session_regenerate_id();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user_id'] = $result[0]['id_client'];
                    header("Location: ../index.php");
                    exit;
                }

                $loginError = 'Invalid login credentials.';
            }
        }

        return $loginError;
    }
}

$loginError = '';

if (isset($_POST['submit-btn'])) {
    $userAuth = new UserAuthentication();
    $loginError = $userAuth->login($_POST['email'], $_POST['password']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
<form action="#" method="POST">
    <h1 for="FilmMarket">FilmMarket</h1>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <input type="submit" value="Login" name="submit-btn" id="login">
    <a href="forgotPassword.php">Forgot password?</a>
    <a href="register.php">new user?</a>
</form>
</body>
</html>
