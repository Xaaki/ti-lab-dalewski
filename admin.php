<?php
require 'auth.php';
require 'baza.php';

$blad = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $akcja = $_POST['akcja'] ?? '';
    if ($akcja === 'dodaj') {
        $nazwa = trim($_POST['nazwa'] ?? '');
        $cena = (int) ($_POST['cena'] ?? 0);
        if ($nazwa !== '' && $cena > 0) {
            $z = $pdo->prepare('INSERT INTO uslugi (nazwa, cena) VALUES (:nazwa, :cena)');
            $z->execute(['nazwa' => $nazwa, 'cena' => $cena]);
            header('Location: admin.php?ok=dodano');
            exit;
        }
        $blad = 'Podaj poprawną nazwę i cenę większą od 0.';
    }
}

$uslugi = $pdo->query('SELECT id, nazwa, cena FROM uslugi ORDER BY nazwa')->fetchAll();
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

    <?php if (($_GET['ok'] ?? '') === 'dodano'): ?>
        <p>Usługa dodana.</p>
    <?php endif; ?>

    <?php if ($blad !== ''): ?>
        <p><?= htmlspecialchars($blad) ?></p>
    <?php endif; ?>

    <h2>Lista usług</h2>
    <table>
        <thead>
            <tr>
                <th>Usługa</th>
                <th>Cena</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($uslugi as $usluga): ?>
                <tr>
                    <td><?= htmlspecialchars($usluga['nazwa']) ?></td>
                    <td><?= (int) $usluga['cena'] ?> zł</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Dodaj usługę</h2>
    <form method="post">
        <input type="hidden" name="akcja" value="dodaj">
        <div>
            <label for="nazwa">Nazwa</label>
            <input id="nazwa" name="nazwa" required maxlength="100">
        </div>
        <div>
            <label for="cena">Cena (zł)</label>
            <input id="cena" name="cena" type="number" min="1" required>
        </div>
        <button type="submit">Dodaj</button>
    </form>
</body>
</html>
