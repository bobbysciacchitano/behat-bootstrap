<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;


/**
 * Features context.
 */
class FeatureContext extends BehatContext
{

    /**
     * @var 
     */
    private static $_webdriver;

    /**
     * @var array
     */
    private $_parameters = array();


    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->_parameters = $parameters;
    }


    /**
     * @Given /^I am on the "([^"]*)" page $/
     */
    public function iAmOnThePage($path)
    {
        $this->getWebdriver()->manage()->deleteAllCookies();

        $this->getWebdriver()->get($this->_parameters['domain'] . $path);
    }


    /**
     * @When /^I enter "([^"]*)" in the "([^"]*)" field $/
     */
    public function iEnterInTheField($value, $field)
    {
        $this->getWebdriver()->findElement(WebDriverBy::name($field))->sendKeys($value);
    }


    /**
     * @Given /^I click the "([^"]*)" button$/
     */
    public function iClickTheButton($label)
    {
        $element = $this->getWebdriver()->findElement(WebDriverBy::xpath('//input[@value="' . $label . '"]'));
        $element->click();
    }


    /**
     * @Then /^I should be redirected to the "([^"]*)" page$/
     */
    public function iShouldBeRedirectedToThePage($path)
    {
        $expected = $this->_parameters['domain'] . $path;

        $response = $this->getWebdriver()->getCurrentURL();

        PHPUnit_Framework_Assert::assertEquals($expected, $response);
    }


    /**
     * @Then /^I should see the message "([^"]*)"$/
     */
    public function iShouldSeeTheMessage($message)
    {
        $response = $this->getWebdriver()->findElement(WebDriverBy::className('error-message'))->getText();

        $response = strip_tags($response);

        PHPUnit_Framework_Assert::assertEquals($message, $response);
    }


    /**
     * @BeforeScenario
     */
    public function resetWebdriver()
    {
        $this->getWebdriver()->manage()->deleteAllCookies();
    }


    /**
     * @AfterSuite 
     */
    public static function teardown(Behat\Behat\Event\SuiteEvent $event)
    {
        if(self::$_webdriver)
        {
            self::$_webdriver->quit();
            self::$_webdriver = null;
        }
    }


    /**
     * Returns an instance of the web driver.
     *
     * @return RemoteWebDriver
     */
    public function getWebdriver()
    {
        if(!self::$_webdriver)
        {
            self::$_webdriver = RemoteWebDriver::create( 
                    $this->_parameters['driver'],
                    $this->_parameters['capabilities']);
        }

        return self::$_webdriver;
    }

}