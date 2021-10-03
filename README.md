# TimeTracker Service

[![Version](https://img.shields.io/badge/Version-0.0.1-blue)](https://github.com/hulkthedev/timetrackerservice)
[![Build Status](https://travis-ci.org/hulkthedev/symfony-clean-architecture-example.svg?branch=develop)](https://travis-ci.org/hulkthedev/timetrackerservice)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=hulkthedev_symfony-clean-architecture-example&metric=alert_status)](https://sonarcloud.io/dashboard?id=hulkthedev_timetrackerservice)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=hulkthedev_symfony-clean-architecture-example&metric=coverage)](https://sonarcloud.io/dashboard?id=hulkthedev_timetrackerservice)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

A simple REST based micro service to demonstrate usage of REST, clean architecture and behat testing. 

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
        "gender": "m",
        "firstName": "John",
        "lastName": "Conner",
        "birthdate": "01.01.1980",
        "street": "Nachtigalplatz",
        "houseNo": "34a",
        "postcode": "13351",
        "city": "Berlin",
        "country": "Germany",
        "sepa": [{
            "iban": "DE02500105170137075030",
            "bic": "INGDDEFF"
        }]
    }]
}
```