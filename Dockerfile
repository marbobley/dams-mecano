FROM composer:latest AS builder
WORKDIR /app
COPY . .
RUN composer install
RUN composer dump-autoload --optimize

# Utilisation de l'image FrankenPHP officielle avec PHP 8.4
FROM dunglas/frankenphp:1-php8.4-alpine

# Installation des extensions PHP nécessaires
RUN install-php-extensions \
    intl \
    zip \
    opcache

# Définition du répertoire de travail
WORKDIR /app

# Copie des fichiers du projet
COPY  --from=builder /app /app

# On s'assure que le dossier public est bien utilisé comme racine du serveur
ENV SERVER_NAME=:80
ENV DOCUMENT_ROOT=/app/public

# FrankenPHP utilise par défaut le serveur Caddy intégré
