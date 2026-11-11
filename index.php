<?php
$firma = 'Szprycha';
$rok = date('Y');

$cennik = [
    ['nazwa' => 'Regulacja hamulców (przód + tył)', 'cena' => 40],
    ['nazwa' => 'Regulacja przerzutek (przód + tył)', 'cena' => 50],
    ['nazwa' => 'Centrowanie koła', 'cena' => 60],
    ['nazwa' => 'Wymiana dętki / opony', 'cena' => 30],
    ['nazwa' => 'Czyszczenie i smarowanie napędu', 'cena' => 80],
];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pracownia Rowerowa Szprycha - Bydgoszcz</title>
    <link rel="stylesheet" href="style.css">
    <script src="app.js" defer></script>
</head>
<body>

    <header class="site-header">
        <a class="logo" href="#">
            <svg viewBox="0 0 120 64" width="72" height="38" role="img" aria-labelledby="logo-tytul">
                <title id="logo-tytul">Szprycha</title>
                
                <!-- Koła roweru (gotowe z prezentacji) -->
                <circle cx="28" cy="42" r="18" fill="none" stroke="#4426FF" stroke-width="5"/>
                <circle cx="92" cy="42" r="18" fill="none" stroke="#4426FF" stroke-width="5"/>
                
                <!-- Rama roweru zrobiona z polyline (dorysowana rama) -->
                <polyline points="28,42 48,14 80,14 92,42" fill="none" stroke="#111111" stroke-width="5"/>
                <polyline points="48,14 60,42 80,14" fill="none" stroke="#111111" stroke-width="5"/>
            </svg>
            <span>Szprycha</span>
        </a>
        <button class="menu-toggle" aria-expanded="false">Menu</button>
        <nav class="menu">
            <a href="#uslugi">Usługi</a>
            <a href="#cennik">Cennik</a>
            <a href="#kontakt">Kontakt</a>
        </nav>
    </header>

    <main>
        <!-- Sekcja 1: Karty usług -->
        <section id="uslugi" class="section">
            <h2>Nasze Usługi</h2>
            <div class="cards">
                <article class="card">
                    <img src="https://via.placeholder.com/300x180?text=Przeglad" alt="Zdjęcie przedstawiające przegląd roweru w warsztacie" class="card-img">
                    <h3>Przegląd podstawowy</h3>
                    <p>Kontrola stanu technicznego, regulacja hamulców oraz przerzutek, smarowanie łańcucha.</p>
                    <p class="card_price">od 120 zł</p>
                </article>

                <article class="card card--highlight">
                    <div class="badge">Najczęściej wybierane</div>
                    <img src="https://via.placeholder.com/300x180?text=Pakiet+Glowny" alt="Mechanik serwisujący napęd rowerowy" class="card-img">
                    <h3>Przegląd rozszerzony</h3>
                    <p>Pełny przegląd podstawowy + czyszczenie napędu, centrowanie kół oraz kasowanie luzów.</p>
                    <p class="card_price">od 220 zł</p>
                </article>

                <article class="card">
                    <img src="https://via.placeholder.com/300x180?text=Serwis+Amortyzatora" alt="Rozłożony amortyzator rowerowy na stole serwisowym" class="card-img">
                    <h3>Serwis zawieszenia</h3>
                    <p>Wymiana oleju, uszczelek oraz czyszczenie komory powietrznej w amortyzatorach przednich.</p>
                    <p class="card_price">od 180 zł</p>
                </article>
            </div>
        </section>

        <!-- Sekcja 2: Cennik -->
        <section id="cennik" class="section">
            <h2>Szczegółowy Cennik</h2>
            <table class="price-table">
                <thead>
                    <tr>
                        <th>Usługa</th>
                        <th class="num">Cena</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cennik as $usluga): ?>
                        <tr>
                            <td><?= htmlspecialchars($usluga['nazwa']) ?></td>
                            <td class="num"><?= $usluga['cena'] ?> zł</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <!-- Stopka: Kontakt -->
    <footer id="kontakt" class="site-footer">
        <h2>Kontakt</h2>
        <p><strong>Pracownia Rowerowa Szprycha</strong></p>
        <p>ul. Gdańska 10, 85-005 Bydgoszcz</p>
        <p>Telefon: <a href="tel:+48500100200">500 100 200</a></p>
        <p>E-mail: <a href="mailto:kontakt@szprycha-bydgoszcz.pl">kontakt@szprycha-bydgoszcz.pl</a></p>
        
        <!-- Wstawienie roku i nazwy firmy z PHP -->
        <p>&copy; <?= $rok ?> <?= $firma ?></p>
    </footer>

</body>
</html>