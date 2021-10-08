#!/usr/bin/env bash

set -eo pipefail

BUILD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
PROJECT_DIR="$(dirname "${BUILD_DIR}")";

# remove databases (root)
if [ -d "var/lib" ]; then
    sudo rm -R var/lib
fi

# remove test metrics
if [ -d "var/reports" ]; then
    rm -R var/lib
fi

# create directories
mkdir -p var/log var/cache
chmod 777 var/log var/cache

# install composer
COMPOSER_CACHE_VOLUME=composer-cache
COMPOSER_IMAGE="composer"
COMPOSER_TAG="2.1.8"

docker run --rm -i -t \
    -v ${CACHE_VOLUME}:/tmp \
    -v "${PROJECT_DIR}":/app \
    --user "$(id -u)":"$(id -g)" \
    -w="/app" \
    --entrypoint="/bin/bash" \
    "${COMPOSER_IMAGE}:${COMPOSER_TAG}" \
    -c "composer global require hirak/prestissimo &> /dev/null; composer install --prefer-dist --no-progress --no-interaction --optimize-autoloader"

# build images
cd "${PROJECT_DIR}" || exit
docker-compose -f docker-compose.yml build

# docker exec php container
# .env MySQL aktivieren
# php bin/console doctrine:database:create

# run container
#cd "${PROJECT_DIR}" || exit
#docker-compose up -d

# run phpunit
#cd "${BUILD_DIR}" || exit
#chmod +x phpunit.sh
#./phpunit.sh