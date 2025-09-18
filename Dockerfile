# -------------------------
# STAGE 1 — Composer (instala dependências PHP)
# -------------------------
FROM composer:2.8.11 AS composer
WORKDIR /app

# Copia apenas os manifestos para aproveitar cache de build
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

# -------------------------
# STAGE 2 — Node (build de assets - Vite)
# -------------------------
FROM node:22.17.0-alpine AS node_builder
WORKDIR /app
COPY package.json package-lock.json* pnpm-lock.yaml* ./
# Usa npm ci/pnpm install conforme lockfile
RUN if [ -f package-lock.json ]; then npm ci --silent; elif [ -f pnpm-lock.yaml ]; then npm ci --silent; fi
COPY . .
RUN npm run build

# -------------------------
# STAGE 3 — Runtime PHP-FPM (imagem final)
# -------------------------
FROM php:8.3-fpm-alpine AS app
ARG APP_ENV=production
ENV APP_ENV=${APP_ENV} \
    APP_DEBUG=false \
    COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

# Instala dependências de sistema necessárias para extensões PHP e para Laravel
RUN apk add --no-cache \
    bash curl git unzip icu-dev oniguruma-dev libzip-dev zlib-dev \
    libpng-dev libjpeg-turbo-dev freetype-dev autoconf gcc g++ make \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) intl mbstring pdo pdo_mysql zip gd

# Copia vendor já instalado da stage composer (evita reinstalar)
COPY --from=composer /app/vendor ./vendor

# Copia código da aplicação
COPY . .

# Copia assets buildados (public/build) do node_builder
COPY --from=node_builder /app/public/build ./public/build

# Ajusta permissões (storage e cache precisam ser graváveis)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 755 /var/www/html

# Executar como usuário não-root (melhora segurança)
USER www-data

# Porta do PHP-FPM
EXPOSE 9000

# Comando padrão: inicia php-fpm
CMD ["php-fpm"]
