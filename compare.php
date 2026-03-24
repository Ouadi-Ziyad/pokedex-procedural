<?php
// Inclusion des fonctions partagées
require_once 'functions.php';

// Titre de la page
$titre_page = 'Comparer deux Pokémon';

// Récupérer les IDs des deux Pokémon à comparer
$id1 = $_GET['id1'] ?? '';
$id2 = $_GET['id2'] ?? '';

// Récupérer les données si les IDs sont fournis
$pokemon1 = null;
$pokemon2 = null;

if ($id1 !== '') {
    $pokemon1 = recuperer_pokemon($id1);
}
if ($id2 !== '') {
    $pokemon2 = recuperer_pokemon($id2);
}

// Inclusion du header HTML
require_once 'header.php';
?>

<h1>Comparer deux Pokémon</h1>

<!-- Formulaire de sélection -->
<form method="get" action="compare.php">
    <div class="grid">
        <label>
            Pokémon 1 (ID ou nom)
            <input 
                type="text" 
                name="id1" 
                placeholder="Ex: 25 ou pikachu" 
                value="<?= htmlspecialchars($id1) ?>"
                required
            >
        </label>
        <label>
            Pokémon 2 (ID ou nom)
            <input 
                type="text" 
                name="id2" 
                placeholder="Ex: 6 ou dracaufeu" 
                value="<?= htmlspecialchars($id2) ?>"
                required
            >
        </label>
    </div>
    <button type="submit">Comparer</button>
</form>

<?php if ($pokemon1 !== null && $pokemon2 !== null): ?>

    <!-- Affichage de la comparaison -->
    <div class="compare-grid">
        <!-- Pokémon 1 -->
        <article class="compare-card">
            <h2>
                <a href="detail.php?id=<?= $pokemon1['pokedex_id'] ?>">
                    #<?= str_pad($pokemon1['pokedex_id'], 3, '0', STR_PAD_LEFT) ?> 
                    <?= htmlspecialchars($pokemon1['name']['fr'] ?? 'Inconnu') ?>
                </a>
            </h2>
            <img 
                src="<?= htmlspecialchars($pokemon1['sprites']['regular'] ?? '') ?>" 
                alt="<?= htmlspecialchars($pokemon1['name']['fr'] ?? '') ?>"
            >
            <div><?= afficher_types($pokemon1['types'] ?? []) ?></div>
            <p><?= htmlspecialchars($pokemon1['category'] ?? '') ?></p>
        </article>

        <!-- Pokémon 2 -->
        <article class="compare-card">
            <h2>
                <a href="detail.php?id=<?= $pokemon2['pokedex_id'] ?>">
                    #<?= str_pad($pokemon2['pokedex_id'], 3, '0', STR_PAD_LEFT) ?> 
                    <?= htmlspecialchars($pokemon2['name']['fr'] ?? 'Inconnu') ?>
                </a>
            </h2>
            <img 
                src="<?= htmlspecialchars($pokemon2['sprites']['regular'] ?? '') ?>" 
                alt="<?= htmlspecialchars($pokemon2['name']['fr'] ?? '') ?>"
            >
            <div><?= afficher_types($pokemon2['types'] ?? []) ?></div>
            <p><?= htmlspecialchars($pokemon2['category'] ?? '') ?></p>
        </article>
    </div>

    <!-- Tableau comparatif des caractéristiques -->
    <h3>Caractéristiques</h3>
    <table>
        <thead>
            <tr>
                <th></th>
                <th><?= htmlspecialchars($pokemon1['name']['fr'] ?? '') ?></th>
                <th><?= htmlspecialchars($pokemon2['name']['fr'] ?? '') ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Taille</th>
                <td><?= htmlspecialchars($pokemon1['height'] ?? '?') ?></td>
                <td><?= htmlspecialchars($pokemon2['height'] ?? '?') ?></td>
            </tr>
            <tr>
                <th>Poids</th>
                <td><?= htmlspecialchars($pokemon1['weight'] ?? '?') ?></td>
                <td><?= htmlspecialchars($pokemon2['weight'] ?? '?') ?></td>
            </tr>
            <tr>
                <th>Taux de capture</th>
                <td><?= $pokemon1['catch_rate'] ?? '?' ?></td>
                <td><?= $pokemon2['catch_rate'] ?? '?' ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Comparaison des statistiques -->
    <?php if (!empty($pokemon1['stats']) && !empty($pokemon2['stats'])): ?>
        <h3>Statistiques</h3>
        <table>
            <thead>
                <tr>
                    <th>Stat</th>
                    <th><?= htmlspecialchars($pokemon1['name']['fr'] ?? '') ?></th>
                    <th><?= htmlspecialchars($pokemon2['name']['fr'] ?? '') ?></th>
                    <th>Différence</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Liste des statistiques à comparer
                $stats = [
                    'hp' => 'PV',
                    'atk' => 'Attaque',
                    'def' => 'Défense',
                    'spe_atk' => 'Atq. Spé.',
                    'spe_def' => 'Déf. Spé.',
                    'vit' => 'Vitesse',
                ];

                $total1 = 0;
                $total2 = 0;

                foreach ($stats as $cle => $nom):
                    $val1 = $pokemon1['stats'][$cle] ?? 0;
                    $val2 = $pokemon2['stats'][$cle] ?? 0;
                    $diff = $val1 - $val2;
                    $total1 += $val1;
                    $total2 += $val2;
                ?>
                    <tr>
                        <th><?= $nom ?></th>
                        <td style="<?= $val1 > $val2 ? 'color: green; font-weight: bold;' : '' ?>"><?= $val1 ?></td>
                        <td style="<?= $val2 > $val1 ? 'color: green; font-weight: bold;' : '' ?>"><?= $val2 ?></td>
                        <td>
                            <?php if ($diff > 0): ?>
                                <span style="color: green;">+<?= $diff ?></span>
                            <?php elseif ($diff < 0): ?>
                                <span style="color: red;"><?= $diff ?></span>
                            <?php else: ?>
                                <span>=</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th><strong>Total</strong></th>
                    <td style="<?= $total1 > $total2 ? 'color: green; font-weight: bold;' : '' ?>"><strong><?= $total1 ?></strong></td>
                    <td style="<?= $total2 > $total1 ? 'color: green; font-weight: bold;' : '' ?>"><strong><?= $total2 ?></strong></td>
                    <td>
                        <?php $diffTotal = $total1 - $total2; ?>
                        <?php if ($diffTotal > 0): ?>
                            <strong style="color: green;">+<?= $diffTotal ?></strong>
                        <?php elseif ($diffTotal < 0): ?>
                            <strong style="color: red;"><?= $diffTotal ?></strong>
                        <?php else: ?>
                            <strong>=</strong>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

<?php elseif ($id1 !== '' || $id2 !== ''): ?>
    <!-- Message d'erreur si un Pokémon n'a pas été trouvé -->
    <p style="color: red;">
        <?php if ($pokemon1 === null && $id1 !== ''): ?>
            Le Pokémon "<?= htmlspecialchars($id1) ?>" n'a pas été trouvé.<br>
        <?php endif; ?>
        <?php if ($pokemon2 === null && $id2 !== ''): ?>
            Le Pokémon "<?= htmlspecialchars($id2) ?>" n'a pas été trouvé.<br>
        <?php endif; ?>
    </p>
<?php endif; ?>

<?php require_once 'footer.php'; ?>
