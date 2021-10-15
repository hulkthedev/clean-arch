Feature:
  invalid or empty userId
  invalid or empty user data
  error response

  Scenario Outline: I want to see a Json Response
    When I set userId to "<userId>"
    And set content type to "<contentType>"
    And want change firstname to "<firstname>"
    And I send a request via "PATCH"
    Then I should see a json response with http status "<httpStatus>"
      """
        {"code":<resultCode>,"entities":[]}
      """

    Examples:
      | userId | resultCode | httpStatus | firstname  | contentType                       |
      | 2      | -2         | 415        | Hans-Meyer | application/x-www-form-urlencoded |
      | 0      | -1         | 400        | Hans-Meyer | application/json                  |
      | 2      | -1         | 400        | null       | application/json                  |
