Feature:
  invalid or empty user data
  error response

  Scenario Outline: I want to see a Json Response
    When I create an new User with Name "John", "null", "30" years old, living in "Beispielstrasse 4, 12345 Musterhausen, Deutschland"
    And set content type to "<contentType>"
    And I send a request via "PUT"
    Then I should see a json response with http status "<httpStatus>"
      """
        {"code":<resultCode>,"entities":[]}
      """

    Examples:
      | resultCode | httpStatus | contentType                       |
      | -1         | 400        | application/json                  |
      | -2         | 415        | application/x-www-form-urlencoded |