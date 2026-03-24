<?php
// Inclusion des fonctions partagées
require_once 'functions.php';

// Titre de la page pour le header
$titre_page = 'Liste des Pokémon';

// Récupérer la recherche si elle existe
$recherche = $_GET['q'] ?? '';

// Récupérer tous les Pokémon via l'API
$tous_les_pokemon = recuperer_tous_les_pokemon();

// Si une recherche est effectuée, filtrer la liste
if ($recherche !== '') {
    $pokemon_affiches = rechercher_pokemon($recherche, $tous_les_pokemon);
} else {
    $pokemon_affiches = $tous_les_pokemon;
}

// Inclusion du header HTML
require_once 'header.php';
?>

<h1>Pokédex</h1>

<!-- Formulaire de recherche -->
<form method="get" action="index.php" class="search-form">
    <input 
        type="search" 
        name="q" 
        placeholder="Rechercher un Pokémon..." 
        value="<?= htmlspecialchars($recherche) ?>"
    >
    <button type="submit">Rechercher</button>
    <?php if ($recherche !== ''): ?>
        <a href="index.php" role="button" class="outline">Effacer</a>
    <?php endif; ?>
</form>

<?php if ($recherche !== ''): ?>
    <p><?= count($pokemon_affiches) ?> résultat(s) pour "<?= htmlspecialchars($recherche) ?>"</p>
<?php endif; ?>

<?php if (empty($pokemon_affiches)): ?>
    <p>Aucun Pokémon trouvé.</p>
<?php else: ?>
    <!-- Grille des Pokémon -->
    <div class="pokemon-grid">
        <?php foreach ($pokemon_affiches as $pokemon): ?>
            <a href="detail.php?id=<?= $pokemon['pokedex_id'] ?>" style="text-decoration: none; color: inherit;">
                <article class="pokemon-card">
                    <span class="pokemon-id">#<?= str_pad($pokemon['pokedex_id'], 3, '0', STR_PAD_LEFT) ?></span>
                    <br>
                    <img 
                        src="<?= htmlspecialchars($pokemon['sprites']['regular'] ?? '') ?>" 
                        alt="<?= htmlspecialchars($pokemon['name']['fr'] ?? 'Inconnu') ?>"
                        loading="lazy"
                    >
                    <h4><?= htmlspecialchars($pokemon['name']['fr'] ?? 'Inconnu') ?></h4>
                    <div>
                        <?php if (!empty($pokemon['types'])): ?>
                            <?= afficher_types($pokemon['types']) ?>
                        <?php endif; ?>
                    </div>
                </article>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once 'footer.php'; ?>
