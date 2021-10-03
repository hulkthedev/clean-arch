
BUILD_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
PROJECT_DIR="$(dirname "${BUILD_DIR}")";

cd "${PROJECT_DIR}" || exit

rm -f .git/hooks/pre-commit
rm -f .git/hooks/pre-push

echo "#! /usr/bin/env bash

cd "${BUILD_DIR}" || exit
./phpunit.sh

if [ \$? -ge 1 ]
then
    echo 'PHPUnit Tests failed!'
    exit 1
else
    echo 'PHPUnit Tests passed!'
fi" >.git/hooks/pre-push

chmod +x .git/hooks/pre-push
