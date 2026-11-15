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
    } elseif ($akcja === 'usun') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $z = $pdo->prepare('DELETE FROM uslugi WHERE id = :id');
            $z->execute(['id' => $id]);
            header('Location: admin.php?ok=usunieto');
            exit;
        }
    }
}

$uslugi = $pdo->query('SELECT id, nazwa, cena FROM uslugi ORDER BY nazwa')->fetchAll();
$ok = $_GET['ok'] ?? '';
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel admina — Szprycha</title>
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="admin.php">Szprycha · Panel</a>
            <div class="navbar-nav ms-auto align-items-center gap-3">
                <span class="navbar-text text-light">Witaj, <?= htmlspecialchars($_SESSION['uzytkownik']) ?></span>
                <a class="nav-link" href="index.php">Strona główna</a>
                <a class="btn btn-outline-light btn-sm" href="wyloguj.php">Wyloguj</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if ($ok === 'dodano'): ?>
            <div class="alert alert-success">Usługa dodana.</div>
        <?php elseif ($ok === 'usunieto'): ?>
            <div class="alert alert-success">Usługa usunięta.</div>
        <?php endif; ?>

        <?php if ($blad !== ''): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($blad) ?></div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Lista usług</h2>
                        <table class="table table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Usługa</th>
                                    <th class="text-end">Cena</th>
                                    <th class="text-end">Akcja</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($uslugi as $usluga): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($usluga['nazwa']) ?></td>
                                        <td class="text-end"><?= (int) $usluga['cena'] ?> zł</td>
                                        <td class="text-end">
                                            <form method="post" class="d-inline">
                                                <input type="hidden" name="akcja" value="usun">
                                                <input type="hidden" name="id" value="<?= (int) $usluga['id'] ?>">
                                                <button class="btn btn-sm btn-outline-danger">Usuń</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Dodaj usługę</h2>
                        <form method="post">
                            <input type="hidden" name="akcja" value="dodaj">
                            <div class="mb-3">
                                <label class="form-label" for="nazwa">Nazwa</label>
                                <input class="form-control" id="nazwa" name="nazwa" required maxlength="100">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="cena">Cena (zł)</label>
                                <input class="form-control" id="cena" name="cena" type="number" min="1" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Dodaj</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
