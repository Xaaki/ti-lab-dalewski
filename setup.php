<?php
require 'baza.php';

$pdo->exec('CREATE TABLE IF NOT EXISTS uslugi (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nazwa TEXT NOT NULL,
    cena INTEGER NOT NULL
)');

$pdo->exec('CREATE TABLE IF NOT EXISTS uzytkownicy (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    login TEXT NOT NULL UNIQUE,
    haslo_hash TEXT NOT NULL
)');

$liczbaUslug = (int) $pdo->query('SELECT COUNT(*) FROM uslugi')->fetchColumn();
if ($liczbaUslug === 0) {
    $z = $pdo->prepare('INSERT INTO uslugi (nazwa, cena) VALUES (:nazwa, :cena)');
    $startowe = [
        ['nazwa' => 'Przegląd', 'cena' => 120],
        ['nazwa' => 'Wymiana dętki', 'cena' => 40],
        ['nazwa' => 'Centrowanie koła', 'cena' => 60],
        ['nazwa' => 'Serwis pełny', 'cena' => 350],
    ];
    foreach ($startowe as $u) {
        $z->execute($u);
    }
}

$liczbaUzytkownikow = (int) $pdo->query('SELECT COUNT(*) FROM uzytkownicy')->fetchColumn();
if ($liczbaUzytkownikow === 0) {
    $z = $pdo->prepare('INSERT INTO uzytkownicy (login, haslo_hash) VALUES (:login, :hash)');
    $z->execute([
        'login' => 'admin',
        'hash' => password_hash('Szprycha!2026', PASSWORD_DEFAULT),
    ]);
}

echo "Baza gotowa.\n";
