<?php

namespace App\Tests\Repository;

use App\Mapper\MariaDbMapper;
use App\Repository\Exception\ContractNotFoundException;
use App\Repository\MariaDbRepository;
use App\Repository\RepositoryInterface;
use App\Tests\Entity\ContractTest;
use App\Tests\TestCaseHelper;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use Throwable;

class MariaDbRepositoryTest extends TestCaseHelper
{
    private const CONTRACT_NUMBER = 1000;

    public function test_GetContractByNumber(): void
    {
        $repo = $this->getPreparedRepository();
        $contract = $repo->getContractByNumber(self::CONTRACT_NUMBER);

        $this->assertContract($contract);
        $this->assertPaymentAccount($contract->getPaymentAccount());
        $this->assertCustomer($contract->getCustomer());
        $this->assertObjects($contract->getObjects());
    }

    public function test_GetContractByNumber_ExpectContractNotFoundException(): void
    {
        $this->expectException(ContractNotFoundException::class);

        $repo = $this->getPreparedRepository(true);
        $repo->getContractByNumber(self::CONTRACT_NUMBER);
    }



    /**
     * @param bool $emptyResult
     * @return RepositoryInterface
     */
    private function getPreparedRepository(bool $emptyResult = false): RepositoryInterface
    {
        $pdoMock = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['prepare'])
            ->getMock();

        $pdoMock->expects($this->any())
            ->method('prepare')
            ->will($this->returnCallback(function ($id) use ($emptyResult) {
                switch ($id) {
                    case 'CALL GetContractByNumber(:contractNumber)':
                        return $this->getPdoStatementStub($emptyResult ? [] : [[
                            'id' => 1,
                            'number' => 1000,
                            'customer_id' => 1,
                            'request_date' => '2021-01-13',
                            'start_date' => '2021-02-01',
                            'end_date' => null,
                            'termination_date' => null,
                            'dunning_level' => 0,
                            'payment_interval' => 30,
                            'firstname' => 'Bill',
                            'lastname' => 'Gates',
                            'age' => 72,
                            'gender' => 'm',
                            'street' => 'Windows Ave.',
                            'house_number' => '3422',
                            'postcode' => '12F000',
                            'city' => 'Los Angeles',
                            'country' => 'USA',
                            'payment_account_holder' => 'Bill Gates',
                            'payment_account_iban' => 'DE02500105170137075030',
                            'payment_account_bic' => 'INGDDEFF',
                            'payment_name' => 'SEPA',
                        ]]);
                    case 'CALL GetObjectsByContractNumber(:contractNumber)':
                        return $this->getPdoStatementStub($emptyResult ? [] : [[
                            'object_id' => 1,
                            'contract_id' => 1,
                            'serial_number' => '24235435436547456',
                            'price' => 1000,
                            'currency' => 'USD',
                            'description' => 'Apple iPhone 11',
                            'buying_date' => '2021-01-01',
                            'start_date' => '2021-02-01',
                            'end_date' => null,
                            'termination_date' => null,
                        ]]);
                    case 'CALL GetRisksByObjectId(:objectId)':
                        return $this->getPdoStatementStub($emptyResult ? [] : [[
                            'object_id' => 1,
                            'name' => 'THEFT_PROTECTION_SMARTPHONE',
                        ]]);
                    default:
                        return [];
                }
            }));

        $repo = new MariaDbRepository(new MariaDbMapper());
        $repo->setPdoDriver($pdoMock);

        return $repo;
    }

    /**
     * @param array $returnValue
     * @return MockObject
     */
    private function getPdoStatementStub(array $returnValue): MockObject
    {
        $statementStub = $this->getMockBuilder(PDOStatement::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['execute', 'closeCursor', 'fetchAll'])
            ->getMock();

        $statementStub->expects($this->any())
            ->method('fetchAll')
            ->willReturn($returnValue);

        return $statementStub;
    }
}
