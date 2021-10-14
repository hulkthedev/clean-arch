Feature:
  invalid or empty userId
  error response

  Scenario Outline: I want to see a Json Response
    When I set userId to "<userId>"
    And a send a request via "GET"
    Then I should see a json response with http status "<httpStatus>"
      """
        {"code":<resultCode>,"entities":[]}
      """

    Examples:
      | userId | resultCode | httpStatus |
      | 0      | -1         | 400        |
      | 30     | -13        | 200        |