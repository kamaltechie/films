<?php
$cookie_name = "user";
$cookie_value = "";
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
?>
<html>
<body>

<?php
if(!isset($_COOKIE[$cookie_name])) {
  echo "Cookie named '" . $cookie_name . "' is not set!";
} else {
  echo "Cookie '" . $cookie_name . "' is set!<br>";
  echo "Value is: " . $_COOKIE[$cookie_name];
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"]; 
    $password = $_POST["password"];

    $dsn = "mysql:host=localhost;dbname=login";
    $dbUsername = "root";
    $dbPassword = "";

    try {
        $pdo = new PDO($dsn, $dbUsername, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute a query to retrieve user data
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        
        if ($user && password_verify($password, $user["password"])) {
            
            $_SESSION["username"] = $username;
            header("Location: acceuil.php"); 
            exit();
        } else {
            echo "nom d'utilisateur ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>
