<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<form action="login.php" method="POST">
    <h1 for="FilmMarket">FilmMarket</h1>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <br>
    <input type="submit" value="Login" id="login">
</form>

<script>
    function showAdminRegistrationPrompt() {
        const password = prompt('Enter the secret password:');
        const correctPassword = 'kamal'; // Replace with your actual secret password

        if (password === correctPassword) {

            window.location.href = 'register.php';
        } else {
            alert('Incorrect password. Please try again.');
        }
    }
</script>

<button onclick="showAdminRegistrationPrompt()">Access Admin Registration</button>
</body>
</html>

<?php

require_once 'C:\Users\hunte\PhpstormProjects\films\DB\config.php';

class UserAuthentication {
    private $connection;

    public function __construct() {
        $this->connection = getConnection();
    }

    public function login($username, $password) {
        $loginError = '';

        if (empty($username) || empty($password)) {
            $loginError = 'Les deux champs sont obligatoires!';
        }

        if (!$loginError) {
            $stmt = $this->connection->prepare('SELECT id_admin, password FROM admin WHERE username = ?');
            $stmt->bindParam(1, $username);

            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($result) > 0 && password_verify($password, $result[0]['password'])) {
                    session_start();
                    session_regenerate_id();
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['name'] = $username;
                    $_SESSION['user_id'] = $result[0]['id'];
                    header("Location: C:\Users\hunte\PhpstormProjects\films\admin\dashboard\index.php");
                    exit;
                }

                $loginError = 'Invalid login!';
            }
        }

        return $loginError;
    }
}

if (isset($_POST['submit-btn'])) {
    $userAuth = new UserAuthentication();
    $loginError = $userAuth->login($_POST['username'], $_POST['password']);
}

?>
