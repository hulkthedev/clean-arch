Feature:
  valid userId
  valid response

  Scenario: I want to see a Json Response
    When I set userId to "1"
    And a send a request via "GET"
    Then I should see a json response:
      """
        {"code":1,
          "entities":[{
              "id":1,
              "firstname":"Max",
              "lastname":"Mustermann",
              "age":30,
              "gender":"m",
              "street":"Musterstrasse",
              "houseNumber":"1",
              "postcode":"12345",
              "city":"Musterstadt",
              "country":"Musterland"
          }]
        }
      """
