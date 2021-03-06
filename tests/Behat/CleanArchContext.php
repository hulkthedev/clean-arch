<?php

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class CleanArchContext implements Context
{
    /** @var KernelInterface */
    private KernelInterface $kernel;

    /** @var Response */
    private Response $response;

    private string $user;
    private string $userId = '';
    private string $path = '/ca-example/';
    private string $contentType = 'application/json';

    public function __construct(KernelInterface $kernel)
    {
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
     * @When set content type to :contentType
     * @param string $contentType
     */
    public function iSetContentType(string $contentType): void
    {
        $this->contentType = $contentType;
    }

    /**
     * @When want change firstname to :firstname
     * @param string $firstname
     */
    public function iChangeFirstnameTo(string $firstname): void
    {
        $this->user = $firstname !== 'null'
            ? json_encode(['firstname' => $firstname])
            : '';
    }

    /**
     * @When I create an new User with Name :firstname, :lastname, :age years old, living in :address
     * @param string $firstname
     * @param string $lastname
     * @param int $age
     * @param string $address
     * @throws Exception
     */
    public function iCreateANewUser(string $firstname, string $lastname, int $age, string $address): void
    {
        $splitAddress = explode(', ', $address);
        $streetAndHouseNumber = explode(' ', $splitAddress[0]);
        $postcodeAndCity = explode(' ', $splitAddress[1]);

        $this->user = json_encode([
            'firstname' => ($firstname === 'null') ? null : $firstname,
            'lastname' => ($lastname === 'null') ? null : $lastname,
            'age' => $age,
            'gender' => 'm',
            'street' => $streetAndHouseNumber[0],
            'houseNumber' => $streetAndHouseNumber[1],
            'postcode' => $postcodeAndCity[0],
            'city' => $postcodeAndCity[1],
            'country' => $splitAddress[2],
        ]);
    }

    /**
     * @When I send a request via :value
     * @param string $method
     * @throws Exception
     */
    public function iSetRequestMethod(string $method): void
    {
        $user = null;
        if ($method === Request::METHOD_PUT || $method === Request::METHOD_PATCH) {
            $user = $this->user;
        }

        $this->response = $this->kernel->handle(Request::create(
            $this->path . $this->userId,
            $method,
            [], [], [],
            ['CONTENT_TYPE' => $this->contentType],
            $user
        ));
    }

    /**
     * @Then I should see a json response with http status :httpStatus
     * @param int $httpStatus
     * @param string $expectedResponseContent
     * @throws Exception
     */
    public function iShouldSeeAJsonResponse(int $httpStatus, string $expectedResponseContent): void
    {
        $this->validateHttpStatus($httpStatus);

        if ($this->response->getStatusCode() !== Response::HTTP_NO_CONTENT) {
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

    /**
     * @param int $expectedHttpStatus
     * @throws Exception
     */
    private function validateHttpStatus(int $expectedHttpStatus): void
    {
        if ($expectedHttpStatus !== $httpStatus = $this->response->getStatusCode()) {
            throw new Exception("Expected http status $expectedHttpStatus does not match with response $httpStatus");
        }
    }
}
