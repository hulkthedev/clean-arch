<?php
//
//namespace App\Tests\Repository;
//
//use App\Entity\User;
//use App\Mapper\MariaDbMapper;
//use App\Repository\Exception\DatabaseException;
//use App\Repository\MariaDbRepository;
//use App\Repository\RepositoryInterface;
//use App\Tests\Entity\UserStub;
//use PDO;
//use PDOStatement;
//use PHPUnit\Framework\MockObject\MockObject;
//use PHPUnit\Framework\TestCase;
//
//class MariaDbRepositoryTest extends TestCase
//{
//    public function test_AddUser_ExpectLastInsertIdFromDBWhenGivingValidUserData(): void
//    {
//        $repo = $this->getPreparedRepository();
//        self::assertEquals(100, $repo->addUser(new UserStub()));
//    }
//
//    public function test_AddUser_ExpectDatabaseExceptionWhenNoLastInsertIdIsAvailable(): void
//    {
//        $this->expectException(DatabaseException::class);
//
//        $repo = $this->getPreparedRepository(true, [], '');
//        $repo->addUser(new UserStub());
//    }
//
//    public function test_GetUserById_ExpectUserAsReturnValue(): void
//    {
//        $dbResult = json_decode(json_encode(new UserStub()), true);
//
//        $repo = $this->getPreparedRepository(true, [$dbResult]);
//        $user = $repo->getUserById(123);
//
//        self::assertInstanceOf(User::class, $user[0]);
//        self::assertCount(1, $user);
//
//        self::assertEquals(1000, $user[0]->id);
//        self::assertEquals('Max', $user[0]->firstname);
//        self::assertEquals('Mustermann', $user[0]->lastname);
//        self::assertEquals(30, $user[0]->age);
//        self::assertEquals('m', $user[0]->gender);
//        self::assertEquals('Musterstraße', $user[0]->street);
//        self::assertEquals('3a', $user[0]->houseNumber);
//        self::assertEquals('12345', $user[0]->postcode);
//        self::assertEquals('Musterdorf', $user[0]->city);
//        self::assertEquals('Musterland', $user[0]->country);
//    }
//
//    public function test_GetUserById_ExpectDatabaseExceptionWhenNoUserWasFound(): void
//    {
//        $this->expectException(DatabaseException::class);
//
//        $repo = $this->getPreparedRepository();
//        $repo->getUserById(123);
//    }
//
//    public function test_DeleteUserById_ExpectUserAsReturnValue(): void
//    {
//        $repo = $this->getPreparedRepository();
//        self::assertTrue($repo->deleteUserById(123));
//    }
//
//    public function test_DeleteUserById_ExpectDatabaseExceptionWhenNoUserWasFound(): void
//    {
//        $this->expectException(DatabaseException::class);
//
//        $repo = $this->getPreparedRepository(false);
//        $repo->deleteUserById(123);
//    }
//
//    public function test_UpdateUserById_ExpectLastInsertIdFromDBWhenGivingValidUserData(): void
//    {
//        $repo = $this->getPreparedRepository();
//        self::assertTrue($repo->updateUserById(new UserStub()));
//    }
//
//    public function test_UpdateUserById_ExpectDatabaseExceptionWhenNoLastInsertIdIsAvailable(): void
//    {
//        $this->expectException(DatabaseException::class);
//
//        $repo = $this->getPreparedRepository(false);
//        $repo->updateUserById(new UserStub());
//    }
//
//    /**
//     * @param bool $executeResult
//     * @param array $fetchAllResult
//     * @param string $lastInsertId
//     * @return RepositoryInterface
//     */
//    private function getPreparedRepository(bool $executeResult = true, array $fetchAllResult = [], string $lastInsertId = '100'): RepositoryInterface
//    {
//        $pdoMock = $this->getPdoMock($executeResult, $fetchAllResult, $lastInsertId);
//
//        $repo = new MariaDbRepository(new MariaDbMapper());
//        $repo->setPdoDriver($pdoMock);
//
//        return $repo;
//    }
//
//    /**
//     * @param string $lastInsertId
//     * @param array $fetchAllResult
//     * @param bool $executeResult
//     * @return MockObject
//     */
//    private function getPdoMock(bool $executeResult, array $fetchAllResult, string $lastInsertId): MockObject
//    {
//        $statementMock = $this->getMockBuilder(PDOStatement::class)
//            ->disableOriginalConstructor()
//            ->onlyMethods(['execute', 'fetchAll'])
//            ->getMock();
//
//        $statementMock->expects($this->any())
//            ->method('execute')
//            ->willReturn($executeResult);
//
//        $statementMock->expects($this->any())
//            ->method('fetchAll')
//            ->willReturn($fetchAllResult);
//
//        $pdoMock = $this->getMockBuilder(PDO::class)
//            ->disableOriginalConstructor()
//            ->onlyMethods(['prepare', 'lastInsertId'])
//            ->getMock();
//
//        $pdoMock->expects($this->once())
//            ->method('prepare')
//            ->willReturn($statementMock);
//
//        $pdoMock->expects($this->any())
//            ->method('lastInsertId')
//            ->willReturn($lastInsertId);
//
//        return $pdoMock;
//    }
//}
