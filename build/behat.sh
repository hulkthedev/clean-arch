#!/usr/bin/env bash

set -eo pipefail

BUILD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
PROJECT_DIR="$(dirname "${BUILD_DIR}")";

SERVICE="symfony-clean-architecture-example_php_1"
CONTAINER=$(docker ps -qf "name=${SERVICE}")

if [[ $CONTAINER == '' ]]; then
    echo "Starting ${SERVICE}..."
    cd "${PROJECT_DIR}" || exit
    docker-compose up -d
fi

echo "Starting Behat Tests..."

docker exec -i ${SERVICE} ./vendor/bin/behat --colors $@

exit $?

RESULT=$?
exit ${RESULT}