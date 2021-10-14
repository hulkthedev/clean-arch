<?php

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class DemoContext implements Context
{
    /** @var KernelInterface */
    private KernelInterface $kernel;

    /** @var Response */
    private Response $response;

    private string $userId = '';
    private string $path = '/ca-example/';

    public function __construct(KernelInterface $kernel)
    {

//        ini_set('display_errors', '0');
//        error_reporting(E_ALL & ~E_STRICT);
//        define('BEHAT_ERROR_REPORTING', E_ERROR);

        $this->kernel = $kernel;
    }

    /**
     * @When I set userId to :value
     * @param string $userId
     */
    public function iSetUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @When a send a request via :value
     * @param string $method
     * @throws Exception
     */
    public function iSetRequestMethod(string $method): void
    {
        $this->response = $this->kernel->handle(Request::create($this->path . $this->userId, $method));
    }

    /**
     * @Then /^I should see a json response:$/
     * @param string $expectedResponseContent
     * @throws Exception
     */
    public function iShouldSeeAJsonResponse(string $expectedResponseContent): void
    {
        $responseAsArray = json_decode($this->response->getContent(), true);
        $expectedResponseAsArray = json_decode($expectedResponseContent, true);

        if ($responseAsArray === null || $expectedResponseAsArray === null) {
            throw new Exception('Input is no json');
        }

        if ($responseAsArray != $expectedResponseAsArray) {
            $exceptionMessage = sprintf('Expected:%s%s%sActual:%s%s%s',
                PHP_EOL,
                print_r($expectedResponseAsArray, true),
                PHP_EOL,
                PHP_EOL,
                print_r($responseAsArray, true),
                PHP_EOL
            );

            throw new Exception($exceptionMessage);
        }
    }
}
