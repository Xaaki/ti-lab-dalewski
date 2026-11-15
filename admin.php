<?php
require 'auth.php';
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel admina — Szprycha</title>
</head>
<body>
    <h1>Witaj, <?= htmlspecialchars($_SESSION['uzytkownik']) ?></h1>
    <p>
        <a href="index.php">Strona główna</a> |
        <a href="wyloguj.php">Wyloguj</a>
    </p>
</body>
</html>
