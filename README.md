# Clean Architecture Example

[![Version](https://img.shields.io/badge/Version-1.0.0-blue)](https://github.com/hulkthedev/symfony-clean-architecture-example)
[![Build Status](https://app.travis-ci.com/hulkthedev/symfony-clean-architecture-example.svg?branch=develop)](https://app.travis-ci.com/github/hulkthedev/symfony-clean-architecture-example)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=hulkthedev_symfony-clean-architecture-example&metric=alert_status)](https://sonarcloud.io/dashboard?id=hulkthedev_symfony-clean-architecture-example)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=hulkthedev_symfony-clean-architecture-example&metric=coverage)](https://sonarcloud.io/dashboard?id=hulkthedev_symfony-clean-architecture-example)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

A simple stateless microservice to demonstrate clean architecture. A contract object is used as an example.
The following operations are planned:
- Show contract
- Terminate contract
- Risk booking (wip)
- Changing customer data (wip)

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

> [GET](http://localhost:3699/clean-arch/contract/1000) /clean-arch/contract/1000
```json
{
  "code": 1,
  "contracts": [
    {
      "id": 1,
      "number": 1000,
      "customerId": 1,
      "requestDate": {
        "date": "2021-01-13 00:00:00.000000",
        "timezone_type": 3,
        "timezone": "UTC"
      },
      "startDate": {
        "date": "2021-02-01 00:00:00.000000",
        "timezone_type": 3,
        "timezone": "UTC"
      },
      "endDate": null,
      "terminationDate": null,
      "dunningLevel": 0,
      "customer": {
        "firstname": "Bill",
        "lastname": "Gates",
        "age": 72,
        "gender": "m",
        "street": "Windows Ave.",
        "houseNumber": "3422",
        "postcode": "12F000",
        "city": "Los Angeles",
        "country": "USA"
      },
      "paymentAccount": {
        "name": "SEPA",
        "holder": "Bill Gates",
        "iban": "DE02500105170137075030",
        "bic": "INGDDEFF",
        "interval": 30
      },
      "objects": [
        {
          "id": 1,
          "serialNumber": "24235435436547456",
          "price": 1000,
          "currency": "USD",
          "description": "Apple iPhone 11",
          "buyingDate": {
            "date": "2021-01-01 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "UTC"
          },
          "startDate": {
            "date": "2021-02-01 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "UTC"
          },
          "endDate": null,
          "terminationDate": null,
          "risks": [
            {
              "name": "THEFT_PROTECTION_SMARTPHONE"
            },
            {
              "name": "DAMAGE_PROTECTION_SMARTPHONE"
            }
          ]
        },
        {
          "id": 2,
          "serialNumber": "47687987964564667",
          "price": 1600,
          "currency": "USD",
          "description": "Samsung QLED 42 Zoll",
          "buyingDate": {
            "date": "2021-05-13 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "UTC"
          },
          "startDate": {
            "date": "2021-06-01 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "UTC"
          },
          "endDate": null,
          "terminationDate": null,
          "risks": [
            {
              "name": "THEFT_PROTECTION_TV"
            },
            {
              "name": "DAMAGE_PROTECTION_TV"
            }
          ]
        },
        {
          "id": 2,
          "serialNumber": "34357769767435776",
          "price": 3500,
          "currency": "USD",
          "description": "Samsung LCD 24 Zoll",
          "buyingDate": {
            "date": "2021-10-07 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "UTC"
          },
          "startDate": {
            "date": "2021-11-01 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "UTC"
          },
          "endDate": null,
          "terminationDate": null,
          "risks": [
            {
              "name": "THEFT_PROTECTION_TV"
            },
            {
              "name": "DAMAGE_PROTECTION_TV"
            }
          ]
        }
      ]
    }
  ]
}
```

> [PUT](http://localhost:3699/clean-arch/contract/1000/terminate/2022-12-31) /clean-arch/contract/1000/terminate/2022-12-31
```json
{
  "code": 1,
  "contracts": []
}
```

> [PUT](http://localhost:3699/clean-arch/contract/1000/object/1/book-risk/3) /clean-arch/contract/1000/object/1/book-risk/3
```json
{
  "code": 1,
  "contracts": []
}
```