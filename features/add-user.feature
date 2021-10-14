Feature:
  valid user data
  valid response

  Scenario: I want to see a Json Response
    When I create an new User with Name "John", "Conner", "30" years old, living in "Beispielstrasse 4, 12345 Musterhausen, Deutschland"
    And I send a request via "PUT"
    Then I should see a json response with http status "201"
      """
        {"code":2,"entities":[]}
      """
