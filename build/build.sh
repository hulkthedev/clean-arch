#!/usr/bin/env bash

set -eo pipefail

BUILD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
PROJECT_DIR="$(dirname "${BUILD_DIR}")";

cd "${PROJECT_DIR}" || exit

# create directories
mkdir -p var/log var/cache
chmod 777 var/log var/cache

cd "${BUILD_DIR}" || exit

# install composer
chmod +x composer.sh
./composer.sh install \
    --prefer-dist \
    --no-progress \
    --no-interaction \
    --optimize-autoloader

# build images
cd "${PROJECT_DIR}/infrastructure" || exit
docker-compose -f docker-compose.yml build

# run container
cd "${PROJECT_DIR}" || exit
docker-compose up -d

# run phpunit
cd "${BUILD_DIR}" || exit
chmod +x phpunit.sh
./phpunit.sh