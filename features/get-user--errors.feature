Feature:
  invalid or empty userId
  error response

  Scenario Outline: I want to see a Json Response
    When I set userId to "<userId>"
    And a send a request via "GET"
    Then I should see a json response:
      """
        {"code":<resultCode>,"entities":[]}
      """

    Examples:
      | userId | resultCode |
      | 0      | -1         |
      | 3      | -13        |