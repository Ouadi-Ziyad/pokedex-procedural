<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex - <?= htmlspecialchars($titre_page ?? 'Accueil') ?></title>
    <!-- PicoCSS pour le style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <style>
        /* Styles personnalisés */
        .pokemon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
        }
        .pokemon-card {
            text-align: center;
            padding: 1rem;
            border: 1px solid var(--pico-muted-border-color);
            border-radius: 8px;
            transition: transform 0.2s;
        }
        .pokemon-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .pokemon-card img {
            width: 120px;
            height: 120px;
            object-fit: contain;
        }
        .pokemon-card .pokemon-id {
            color: var(--pico-muted-color);
            font-size: 0.85rem;
        }
        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--pico-secondary-background);
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            margin: 2px;
        }
        .type-badge img {
            width: 20px;
            height: 20px;
        }
        .stat-row {
            display: grid;
            grid-template-columns: 100px 40px 1fr;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.3rem;
        }
        .stat-row progress {
            margin: 0;
        }
        .compare-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        .compare-card {
            text-align: center;
        }
        .compare-card > img {
            width: 200px;
            height: 200px;
            object-fit: contain;
        }
        nav a {
            margin-right: 1rem;
        }
        .search-form {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }
        .search-form input {
            margin-bottom: 0;
        }
        .pokemon-detail-img {
            width: 250px;
            height: 250px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <nav class="container">
        <ul>
            <li><strong>Pokédex</strong></li>
        </ul>
        <ul>
            <li><a href="index.php">Liste</a></li>
            <li><a href="compare.php">Comparer</a></li>
        </ul>
    </nav>
    <main class="container">
