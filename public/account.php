<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href=" assets/css/style2.css">
</head>
<body>
<div id="profile-update">
    <h2>User Profile</h2>
    <form action="index.php" method="POST">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" id="nom" value="User's Nom" required>
        <br>
        <label for="prenom">Prenom:</label>
        <input type="text" name="prenom" id="prenom" value="User's Prenom" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="user@example.com" required>
        <br>
        <label for="adresse">Adresse:</label>
        <input type="text" name="adresse" id="adresse" value="User's Adresse" required>
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

<script>
    // You can add a script here to toggle the visibility of the form when needed
</script>
</body>
</html>
