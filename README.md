# Clean Architecture Example

[![Version](https://img.shields.io/badge/Version-1.0.0-blue)](https://github.com/hulkthedev/symfony-clean-architecture-example)
[![Build Status](https://app.travis-ci.com/hulkthedev/symfony-clean-architecture-example.svg?branch=develop)](https://app.travis-ci.com/github/hulkthedev/symfony-clean-architecture-example)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=hulkthedev_symfony-clean-architecture-example&metric=alert_status)](https://sonarcloud.io/dashboard?id=hulkthedev_symfony-clean-architecture-example)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=hulkthedev_symfony-clean-architecture-example&metric=coverage)](https://sonarcloud.io/dashboard?id=hulkthedev_symfony-clean-architecture-example)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

A simple REST based microservice to demonstrate usage of REST, clean architecture and behat testing.

##### CI Error

Unfortunately, Travis CI does not yet support PHP 8.x

##### build

```bash
./build/build.sh
```

##### phpunit

```bash
./build/phpunit.sh
```

##### behat

```bash
./build/behat.sh
```

##### Examples

> [GET](http://localhost:3699/ca-example/1) /ca-example/1
```json
{
    "code": 1,
    "user": [{
        "id": 1,
        "firstname": "Max",
        "lastname": "Mustermann",
        "age": 30,
        "gender": "m",
        "street": "Musterstrasse",
        "houseNo": "1",
        "postcode": "12345",
        "city": "Musterstadt",
        "country": "Musterland"
    }]
}
```