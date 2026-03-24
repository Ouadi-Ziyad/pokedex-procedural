<?php

/**
 * Effectue une requête GET vers l'API Tyradex avec cURL
 * 
 * @param string $url L'URL de l'API à appeler
 * @return array|null Les données décodées en tableau associatif, ou null en cas d'erreur
 */
function appeler_api(string $url): ?array
{
    // Initialiser cURL
    $ch = curl_init();

    // Configurer les options de cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: PokedexBTS',
        'Content-type: application/json',
    ]);

    // Exécuter la requête
    $reponse = curl_exec($ch);
    $code_http = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Fermer cURL
    curl_close($ch);

    // Vérifier que la requête a réussi
    if ($code_http !== 200 || $reponse === false) {
        return null;
    }

    // Décoder le JSON en tableau associatif
    return json_decode($reponse, true);
}

/**
 * Récupère la liste de tous les Pokémon
 * 
 * @return array La liste des Pokémon
 */
function recuperer_tous_les_pokemon(): array
{
    $donnees = appeler_api('https://tyradex.app/api/v1/pokemon');
    if ($donnees === null) {
        return [];
    }
    // Filtrer l'entrée vide (index 0 qui est souvent vide dans l'API)
    return array_filter($donnees, function ($pokemon) {
        return isset($pokemon['pokedex_id']) && $pokemon['pokedex_id'] > 0;
    });
}

/**
 * Récupère les détails d'un Pokémon par son ID ou son nom
 * 
 * @param int|string $identifiant L'ID ou le nom du Pokémon
 * @return array|null Les données du Pokémon ou null si non trouvé
 */
function recuperer_pokemon($identifiant): ?array
{
    return appeler_api('https://tyradex.app/api/v1/pokemon/' . urlencode($identifiant));
}

/**
 * Recherche des Pokémon par nom (français) dans la liste complète
 * 
 * @param string $recherche Le terme de recherche
 * @param array $liste La liste complète des Pokémon
 * @return array Les Pokémon correspondants
 */
function rechercher_pokemon(string $recherche, array $liste): array
{
    $recherche = mb_strtolower($recherche);
    return array_filter($liste, function ($pokemon) use ($recherche) {
        $nom = mb_strtolower($pokemon['name']['fr'] ?? '');
        return str_contains($nom, $recherche);
    });
}

/**
 * Affiche le(s) type(s) d'un Pokémon sous forme de badges
 * 
 * @param array $types Les types du Pokémon
 * @return string Le HTML des badges
 */
function afficher_types(array $types): string
{
    $html = '';
    foreach ($types as $type) {
        $nom = htmlspecialchars($type['name'] ?? '');
        $image = htmlspecialchars($type['image'] ?? '');
        $html .= '<span class="type-badge">';
        if ($image) {
            $html .= '<img src="' . $image . '" alt="' . $nom . '" width="20" height="20"> ';
        }
        $html .= $nom . '</span> ';
    }
    return $html;
}

/**
 * Affiche une barre de statistique
 * 
 * @param string $nom Le nom de la stat
 * @param int $valeur La valeur de la stat
 * @return string Le HTML de la barre
 */
function afficher_barre_stat(string $nom, int $valeur): string
{
    $pourcentage = min(100, round(($valeur / 255) * 100));
    return '<div class="stat-row">
        <strong>' . htmlspecialchars($nom) . '</strong>
        <span>' . $valeur . '</span>
        <progress value="' . $valeur . '" max="255">' . $pourcentage . '%</progress>
    </div>';
}
