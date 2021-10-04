#!/usr/bin/env bash

set -eo pipefail

BUILD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
PROJECT_DIR="$(dirname "${BUILD_DIR}")";

# create directories
mkdir -p var/log var/cache
chmod 777 var/log var/cache

COMPOSER_CACHE_VOLUME=composer-cache
COMPOSER_IMAGE="composer"
COMPOSER_TAG="2.1.8"

# install composer
docker run --rm -i -t \
    -v ${CACHE_VOLUME}:/tmp \
    -v "${PROJECT_DIR}":/app \
    --user "$(id -u)":"$(id -g)" \
    -w="/app" \
    --entrypoint="/bin/bash" \
    "${COMPOSER_IMAGE}:${COMPOSER_TAG}" \
    -c "composer global require hirak/prestissimo &> /dev/null; composer install --prefer-dist --no-progress --no-interaction --optimize-autoloader"

# build images
#cd "${PROJECT_DIR}/infrastructure" || exit
#docker-compose -f docker-compose.yml build

# run container
#cd "${PROJECT_DIR}" || exit
#docker-compose up -d

# run phpunit
#cd "${BUILD_DIR}" || exit
#chmod +x phpunit.sh
#./phpunit.sh