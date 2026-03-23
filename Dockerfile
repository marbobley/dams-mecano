# Utilisation de l'image FrankenPHP officielle avec PHP 8.2+
FROM dunglas/frankenphp:latest-php8.3-alpine

# Définition de variables d'environnement utiles pour Symfony
ENV APP_ENV=prod
ENV APP_RUNTIME=Runtime\\FrankenPhp\\Runtime

# Installation des extensions PHP nécessaires (basé sur votre composer.json)
RUN install-php-extensions \
    intl \
    zip \
    opcache

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définition du répertoire de travail
WORKDIR /app

# Copie des fichiers du projet
COPY . .

# Installation des dépendances (sans les scripts pour le moment)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Configuration des droits sur les dossiers var/
RUN mkdir -p var/cache var/log && \
    chown -R www-data:www-data var/

# Exposition du port par défaut (80 pour HTTP, 443 pour HTTPS)
EXPOSE 80
EXPOSE 443
EXPOSE 443/udp

# Commande par défaut pour lancer FrankenPHP
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
