📖 Pokédex Interactif (Version Procédurale)
Bienvenue sur le projet Pokédex ! Il s'agit d'un site web interactif qui permet de consulter les informations de tous les Pokémon existants.

Ce projet a été conçu pour être simple, direct et facile à comprendre, idéal pour faire ses premiers pas dans la création de sites web dynamiques.

✨ Ce que vous pouvez faire sur le site
🔍 Explorer et chercher : Parcourez la liste complète des Pokémon ou utilisez la barre de recherche pour trouver votre préféré rapidement.

📖 Voir les détails : Cliquez sur un Pokémon pour découvrir toutes ses caractéristiques (sa taille, son poids, ses statistiques de combat, ses évolutions et même sa version brillante/"shiny").

⚖️ Comparer : Vous hésitez entre deux Pokémon ? Un outil de comparaison permet de mettre leurs statistiques côte à côte pour voir lequel est le plus fort.

🧠 Comment ça marche sous le capot ? (Explications simples)
Ce projet utilise deux concepts : l'API pour trouver les informations, et la programmation procédurale pour les afficher.

1. Les données (L'API Tyradex)
Le site ne stocke aucune information sur les Pokémon directement dans ses dossiers. À la place, il va "poser la question" en direct à une immense base de données publique sur internet appelée Tyradex API. C'est comme si notre site consultait une grande encyclopédie en ligne à chaque fois que vous cliquez sur un Pokémon.

2. L'organisation du code (L'approche Procédurale)
Le code de ce site est écrit de manière procédurale. Imaginez que chaque page du site fonctionne comme une recette de cuisine que l'on lit de haut en bas :

La préparation : Quand vous ouvrez la page d'un Pokémon, le fichier demande d'abord les outils partagés (la "boîte à outils" contenant nos fonctions).

Les courses : Il va lui-même chercher les bonnes informations dans l'encyclopédie (l'API).

Le dressage : Dès qu'il a les informations, il génère les images, les textes et les couleurs directement à la suite.

Contrairement à des méthodes où le travail est divisé entre plusieurs fichiers différents avec des rôles complexes, ici, la logique est directe, linéaire et étape par étape. C'est la méthode la plus naturelle et la plus intuitive pour comprendre le fonctionnement d'une page web !

🛠️ Comment lancer le projet chez vous ?
Pour que le site fonctionne sur n'importe quel ordinateur très facilement, nous utilisons un outil appelé Docker. C'est une sorte de "boîte" qui contient tout ce dont le site a besoin pour fonctionner.

Si vous avez Docker installé sur votre ordinateur, voici les étapes :

Ouvrez un terminal (invite de commande) dans le dossier de ce projet.

Tapez la commande suivante :

Bash
docker-compose up -d
Ouvrez votre navigateur internet et allez à l'adresse suivante : http://localhost:8000

Profitez de votre Pokédex !

🤝 Crédits
Données : Toutes les informations et images des Pokémon proviennent de l'excellente API Tyradex (https://tyradex.app/).

Design : L'apparence visuelle claire et moderne est réalisée grâce à PicoCSS, un outil qui rend les sites élégants très facilement.

Pokémon et tous les noms respectifs sont des marques déposées de The Pokémon Company International.
