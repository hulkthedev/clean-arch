<?php

namespace App\Tests\Repository;

use App\Mapper\MariaDbMapper;
use App\Repository\Exception\ContractNotFoundException;
use App\Repository\MariaDbRepository;
use App\Repository\RepositoryInterface;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MariaDbRepositoryTest extends TestCase
{
    public function test_GetContractByNumber(): void
    {

    }

    public function test_GetContractByNumber_ExpectContractNotFoundException(): void
    {
        $this->expectException(ContractNotFoundException::class);

        $repo = $this->getPreparedRepository();
        $repo->getContractByNumber(123);
    }

    /**
     * @param bool $executeResult
     * @param array $fetchAllResult
     * @param string $lastInsertId
     * @return RepositoryInterface
     */
    private function getPreparedRepository(bool $executeResult = true, array $fetchAllResult = [], string $lastInsertId = '100'): RepositoryInterface
    {
        $pdoMock = $this->getPdoMock($executeResult, $fetchAllResult, $lastInsertId);

        $repo = new MariaDbRepository(new MariaDbMapper());
        $repo->setPdoDriver($pdoMock);

        return $repo;
    }

    /**
     * @param array $fetchAllResult
     * @param bool $executeResult
     * @return MockObject
     */
    private function getPdoMock(bool $executeResult, array $fetchAllResult): MockObject
    {
        $statementMock = $this->getMockBuilder(PDOStatement::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['execute', 'fetchAll'])
            ->getMock();

        $statementMock->expects($this->any())
            ->method('execute')
            ->willReturn($executeResult);

        $statementMock->expects($this->any())
            ->method('fetchAll')
            ->willReturn($fetchAllResult);

        $pdoMock = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['prepare'])
            ->getMock();

        $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($statementMock);

        return $pdoMock;
    }
}
