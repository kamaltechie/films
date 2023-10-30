<?php

$nomeutente = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saluti</title>
</head>
<body>
<h5>Bonjour <?= $nomeutente ?></h5>
</body>
</html>
