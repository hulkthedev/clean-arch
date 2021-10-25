<?php

namespace App\Tests\Repository;

use App\Mapper\MariaDbMapper;
use App\Repository\Exception\ContractNotFoundException;
use App\Repository\MariaDbRepository;
use App\Repository\RepositoryInterface;
use App\Tests\TestCaseHelper;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;

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
                        return $this->getPdoStatementStub($emptyResult ? [] : $this->getRawContractData());
                    case 'CALL GetObjectsByContractNumber(:contractNumber)':
                        return $this->getPdoStatementStub($emptyResult ? [] : $this->getRawObjectData());
                    case 'CALL GetRisksByObjectId(:objectId)':
                        return $this->getPdoStatementStub($emptyResult ? [] : $this->getRawRiskData());
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
