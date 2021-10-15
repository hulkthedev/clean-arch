Feature:
  valid user id
  valid response

  Scenario: I want to see a Json Response
    When I set userId to "3"
    And I send a request via "DELETE"
    Then I should see a json response with http status "204"
      """
        {"code":3,"entities":[]}
      """
