# Bonnes Pratiques Docker pour le projet dams-mecano

Ce document décrit les recommandations pour la construction et la gestion des images Docker du projet.

## 1. Utilisation d'Images de Base Minimales
- Utiliser des images `alpine` (déjà fait via `frankenphp:latest-php8.3-alpine`) pour réduire la taille de l'image et la surface d'attaque.
- Fixer les versions majeures des images (ex: `8.3`) pour assurer la reproductibilité.

## 2. Optimisation des Layers (Couches)
- Regrouper les commandes `RUN` pour limiter le nombre de couches.
- Placer les instructions qui changent peu (installation d'extensions, variables d'environnement) au début du Dockerfile.
- Installer les dépendances (Composer) avant de copier tout le code source pour profiter du cache Docker.

## 3. Multi-stage Builds
- Utiliser des étapes de construction distinctes pour le développement et la production.
- Séparer la phase de build (compilation d'assets, installation de composer) de l'image finale de production pour réduire son poids (ne pas laisser Composer ou Node dans l'image finale).

## 4. Sécurité
- Ne jamais exécuter le conteneur en tant que `root` en production (utiliser l'utilisateur `www-data`).
- Gérer les permissions sur les dossiers `var/cache` et `var/log` de manière stricte.
- Utiliser des variables d'environnement pour les secrets (via `.env` ou Kubernetes/Docker Secrets).

## 5. Gestion du Contexte (.dockerignore)
- Toujours utiliser un fichier `.dockerignore` pour éviter d'inclure des fichiers inutiles ou sensibles dans l'image (ex: `.git`, `node_modules`, `tests`, `var/cache/*`).
- Cela réduit le temps de build et la taille de l'image.

## 6. Configuration Symfony
- S'assurer que `APP_ENV=prod` est défini par défaut dans l'image de production.
- Optimiser l'autoloader de Composer (`--optimize-autoloader --no-dev`).
- Préchauffer le cache Symfony lors du build (`php bin/console cache:warmup`).

## 7. Journalisation et Monitoring
- Envoyer les logs vers `stdout/stderr` pour qu'ils soient capturés par le moteur Docker.
- Utiliser un `HEALTHCHECK` pour surveiller l'état de santé du service FrankenPHP.
