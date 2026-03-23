# Utilisation de l'image FrankenPHP officielle avec PHP 8.3 Alpine
FROM dunglas/frankenphp:1-php8.3-alpine

# Variables d'environnement
ENV APP_ENV=prod
ENV APP_RUNTIME=Runtime\\FrankenPhp\\Runtime
ENV APP_SECRET=ChangeMeInProduction

# Installation des extensions PHP nécessaires
RUN install-php-extensions \
    intl \
    zip \
    opcache

# Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définition du répertoire de travail
WORKDIR /app

# Optimisation du cache Docker pour Composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Copie des fichiers du projet (filtré par .dockerignore)
COPY . .

# Droits d'accès, création des dossiers Caddy et Warmup
# On donne les droits à www-data sur les dossiers dont FrankenPHP/Caddy a besoin
RUN mkdir -p var/cache var/log /data/caddy /config/caddy && \
    chown -R www-data:www-data var/ /data/caddy /config/caddy && \
    php bin/console cache:warmup

# Utilisation de l'utilisateur non-root pour la sécurité
USER www-data

# Exposition du port par défaut (80 pour HTTP, 443 pour HTTPS)
EXPOSE 80 443 443/udp

# Commande par défaut pour lancer FrankenPHP
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
