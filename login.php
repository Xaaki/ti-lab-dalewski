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
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h4 mb-3">Panel admina — Logowanie</h1>

                        <?php if ($blad !== ''): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($blad) ?></div>
                        <?php endif; ?>

                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label" for="login">Login</label>
                                <input class="form-control" id="login" name="login" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="haslo">Hasło</label>
                                <input class="form-control" id="haslo" name="haslo" type="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Zaloguj</button>
                        </form>

                        <p class="mt-3 mb-0 text-center">
                            <a href="index.php">Powrót do cennika</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
