<?php
session_start();

if (!empty($_SESSION['uzytkownik'])) {
    header('Location: admin.php');
    exit;
}

$blad = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'baza.php';

    $z = $pdo->prepare('SELECT login, haslo_hash FROM uzytkownicy WHERE login = :login');
    $z->execute(['login' => trim($_POST['login'] ?? '')]);
    $u = $z->fetch();

    if ($u && password_verify($_POST['haslo'] ?? '', $u['haslo_hash'])) {
        session_regenerate_id(true);
        $_SESSION['uzytkownik'] = $u['login'];
        header('Location: admin.php');
        exit;
    }

    $blad = 'Błędny login lub hasło.';
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie — Szprycha</title>
</head>
<body>
    <h1>Panel admina — Logowanie</h1>

    <?php if ($blad !== ''): ?>
        <p><?= htmlspecialchars($blad) ?></p>
    <?php endif; ?>

    <form method="post">
        <div>
            <label for="login">Login</label>
            <input id="login" name="login" required>
        </div>
        <div>
            <label for="haslo">Hasło</label>
            <input id="haslo" name="haslo" type="password" required>
        </div>
        <button type="submit">Zaloguj</button>
    </form>

    <p><a href="index.php">Powrót do cennika</a></p>
</body>
</html>
