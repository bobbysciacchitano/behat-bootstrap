
Feature: User account authentication


Scenario: Login with valid password

Given I am on the "login" page 
When I enter "james" in the "username" field 
  And I enter "loveslamp" in the "password" field 
  And I click the "Login" button
Then I should be redirected to the "my-account" page


Scenario: Login with invalid password

Given I am on the "login" page 
When I enter "james" in the "username" field 
  And I enter "lovescouch" in the "password" field 
  And I click the "Login" button
Then I should see the message "Invalid username or password"
