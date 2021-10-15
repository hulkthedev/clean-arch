Feature:
  valid user data
  valid response

  Scenario: I want to see a Json Response
    When I set userId to "2"
    And want change firstname to "Hans-Meyer"
    And I send a request via "PATCH"
    Then I should see a json response with http status "204"
      """
        {"code":3,"entities":[]}
      """
