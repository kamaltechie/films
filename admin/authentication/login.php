    <?php

    require '../../db/config.php';


    session_start();

    if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
        // Distruggi la sessione
        session_destroy();
        // Reindirizza l'utente alla pagina di login
        header('Location: login.php');
        exit;
    }


    class UserAuthentication {
        private $connection;

        public function __construct() {
            $database = new Database();
            $this->connection = $database->getConnection();
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

                    print_r($result);
                    $result2 = password_verify($password, $result[0]['password']);
                    var_dump($result2);
                    if (count($result) > 0 && password_verify($password, $result[0]['password'])) {
                        session_start();
                        session_regenerate_id();
                        $_SESSION['loggedin'] = TRUE;
                        $_SESSION['name'] = $username;
                        $_SESSION['user_id'] = $result[0]['id'];
                        header("Location: /films/admin/dashboard/test.php");
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

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
    <form action="#" method="POST">
        <h1 for="FilmMarket">FilmMarket</h1>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Login" name="submit-btn" id="login">
        <button id="adminRegister" onclick="showAdminRegistrationPrompt()">Access Admin Registration</button>
    </form>

    <script>
        function showAdminRegistrationPrompt() {
            var attemps = 3;
            const password = prompt('Enter the secret password:');
            const correctPassword = 'kamal'; // Replace with your actual secret password

            if (password === correctPassword) {
                window.location.href = 'register.php';
            } else {
                attemps--;
                alert('Incorrect password. Please try again, you have ' + attemps + ' attemps left.');
                if (attemps == 0) {
                    alert('You have no more attemps left, please try again later.');
            }

            }
        }
    </script>
    </body>
    </html>






