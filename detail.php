<?php
// Inclusion des fonctions partagées
require_once 'functions.php';

// Récupérer l'ID du Pokémon depuis l'URL
$id = $_GET['id'] ?? null;

// Vérifier qu'un ID a été fourni
if ($id === null) {
    header('Location: index.php');
    exit;
}

// Récupérer les données du Pokémon via l'API
$pokemon = recuperer_pokemon($id);

// Vérifier que le Pokémon existe
if ($pokemon === null || isset($pokemon['status']) && $pokemon['status'] === 404) {
    $titre_page = 'Pokémon non trouvé';
    require_once 'header.php';
    echo '<h1>Pokémon non trouvé</h1>';
    echo '<p>Le Pokémon demandé n\'existe pas.</p>';
    echo '<a href="index.php" role="button">Retour à la liste</a>';
    require_once 'footer.php';
    exit;
}

// Titre de la page
$titre_page = $pokemon['name']['fr'] ?? 'Détail';

// Inclusion du header HTML
require_once 'header.php';
?>

<a href="index.php">&larr; Retour à la liste</a>

<article>
    <header>
        <hgroup>
            <h1>
                #<?= str_pad($pokemon['pokedex_id'], 3, '0', STR_PAD_LEFT) ?> 
                - <?= htmlspecialchars($pokemon['name']['fr'] ?? 'Inconnu') ?>
            </h1>
            <p>
                <?= htmlspecialchars($pokemon['name']['en'] ?? '') ?> 
                | <?= htmlspecialchars($pokemon['name']['jp'] ?? '') ?>
                | <?= htmlspecialchars($pokemon['category'] ?? '') ?>
            </p>
        </hgroup>
    </header>

    <div style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: flex-start;">
        <!-- Image du Pokémon -->
        <div style="text-align: center;">
            <img 
                class="pokemon-detail-img"
                src="<?= htmlspecialchars($pokemon['sprites']['regular'] ?? '') ?>" 
                alt="<?= htmlspecialchars($pokemon['name']['fr'] ?? '') ?>"
            >
            <?php if (!empty($pokemon['sprites']['shiny'])): ?>
                <br>
                <details>
                    <summary>Version Shiny</summary>
                    <img 
                        class="pokemon-detail-img"
                        src="<?= htmlspecialchars($pokemon['sprites']['shiny']) ?>" 
                        alt="<?= htmlspecialchars($pokemon['name']['fr'] ?? '') ?> shiny"
                    >
                </details>
            <?php endif; ?>
        </div>

        <!-- Informations générales -->
        <div style="flex: 1; min-width: 300px;">
            <!-- Types -->
            <h3>Types</h3>
            <div>
                <?php if (!empty($pokemon['types'])): ?>
                    <?= afficher_types($pokemon['types']) ?>
                <?php else: ?>
                    <p>Aucun type connu</p>
                <?php endif; ?>
            </div>

            <!-- Taille et poids -->
            <h3>Caractéristiques</h3>
            <table>
                <tr>
                    <th>Taille</th>
                    <td><?= htmlspecialchars($pokemon['height'] ?? '?') ?></td>
                </tr>
                <tr>
                    <th>Poids</th>
                    <td><?= htmlspecialchars($pokemon['weight'] ?? '?') ?></td>
                </tr>
                <?php if (isset($pokemon['catch_rate'])): ?>
                <tr>
                    <th>Taux de capture</th>
                    <td><?= $pokemon['catch_rate'] ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($pokemon['egg_groups'])): ?>
                <tr>
                    <th>Groupes d'œufs</th>
                    <td><?= htmlspecialchars(implode(', ', $pokemon['egg_groups'])) ?></td>
                </tr>
                <?php endif; ?>
                <?php if (isset($pokemon['sexe'])): ?>
                <tr>
                    <th>Sexe</th>
                    <td>
                        <?php if ($pokemon['sexe']['male'] == 0 && $pokemon['sexe']['female'] == 0): ?>
                            Asexué
                        <?php else: ?>
                            ♂ <?= $pokemon['sexe']['male'] ?>% | ♀ <?= $pokemon['sexe']['female'] ?>%
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endif; ?>
            </table>

            <!-- Talents -->
            <?php if (!empty($pokemon['talents'])): ?>
                <h3>Talents</h3>
                <ul>
                    <?php foreach ($pokemon['talents'] as $talent): ?>
                        <li>
                            <?= htmlspecialchars($talent['name'] ?? '') ?>
                            <?php if (!empty($talent['tc'])): ?>
                                <small>(talent caché)</small>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <!-- Statistiques -->
    <?php if (!empty($pokemon['stats'])): ?>
        <h3>Statistiques</h3>
        <?= afficher_barre_stat('PV', $pokemon['stats']['hp'] ?? 0) ?>
        <?= afficher_barre_stat('Attaque', $pokemon['stats']['atk'] ?? 0) ?>
        <?= afficher_barre_stat('Défense', $pokemon['stats']['def'] ?? 0) ?>
        <?= afficher_barre_stat('Atq. Spé.', $pokemon['stats']['spe_atk'] ?? 0) ?>
        <?= afficher_barre_stat('Déf. Spé.', $pokemon['stats']['spe_def'] ?? 0) ?>
        <?= afficher_barre_stat('Vitesse', $pokemon['stats']['vit'] ?? 0) ?>
    <?php endif; ?>

    <!-- Évolutions -->
    <?php if (!empty($pokemon['evolution'])): ?>
        <h3>Évolutions</h3>
        <?php if (!empty($pokemon['evolution']['pre'])): ?>
            <h4>Pré-évolution(s)</h4>
            <ul>
                <?php foreach ($pokemon['evolution']['pre'] as $evo): ?>
                    <li>
                        <a href="detail.php?id=<?= $evo['pokedex_id'] ?>">
                            <?= htmlspecialchars($evo['name']) ?>
                        </a>
                        <small>(<?= htmlspecialchars($evo['condition'] ?? '') ?>)</small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($pokemon['evolution']['next'])): ?>
            <h4>Évolution(s) suivante(s)</h4>
            <ul>
                <?php foreach ($pokemon['evolution']['next'] as $evo): ?>
                    <li>
                        <a href="detail.php?id=<?= $evo['pokedex_id'] ?>">
                            <?= htmlspecialchars($evo['name']) ?>
                        </a>
                        <small>(<?= htmlspecialchars($evo['condition'] ?? '') ?>)</small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Résistances -->
    <?php if (!empty($pokemon['resistances'])): ?>
        <details>
            <summary>Résistances</summary>
            <table>
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Multiplicateur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pokemon['resistances'] as $resistance): ?>
                        <tr>
                            <td><?= htmlspecialchars($resistance['name'] ?? '') ?></td>
                            <td>
                                <?php
                                $mult = $resistance['multiplier'] ?? 1;
                                if ($mult == 0) {
                                    echo '0 (immunisé)';
                                } elseif ($mult < 1) {
                                    echo 'x' . $mult . ' (résistant)';
                                } elseif ($mult > 1) {
                                    echo 'x' . $mult . ' (faible)';
                                } else {
                                    echo 'x1 (neutre)';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </details>
    <?php endif; ?>
</article>

<?php require_once 'footer.php'; ?>
