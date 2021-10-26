<?php

namespace App\Repository;

use App\Entity\Contract;
use App\Repository\Exception\ContractCanNotBeTerminatedException;
use App\Repository\Exception\ContractNotFoundException;
use App\Repository\Exception\DatabaseUnreachableException;
use App\Repository\Exception\ObjectNotFoundException;
use App\Repository\Exception\RisksNotFoundException;
use App\Usecase\BookRisk\Exception\RiskCanNotBeBookedException;
use App\Usecase\ResultCodes;
use PDO;
use App\Mapper\MariaDbMapper as Mapper;

class MariaDbRepository implements RepositoryInterface
{
    private const DATABASE_CONNECTION_TIMEOUT = 30;

    private ?PDO $pdo = null;
    private Mapper $mapper;

    /**
     * @param Mapper $mapper
     */
    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param int $objectId
     * @param int $riskType
     * @return bool
     * @throws DatabaseUnreachableException
     * @throws RiskCanNotBeBookedException
     */
    public function bookRisk(int $objectId, int $riskType): bool
    {
        $statement = $this->getPdoDriver()->prepare('CALL BookRisk(:objectId, :riskType)');
        $result = $statement->execute([
            'objectId' => $objectId,
            'riskType' => $riskType,
        ]);

        $statement->closeCursor();

        if (true !== $result) {
            throw new RiskCanNotBeBookedException(ResultCodes::RISK_TYPE_ERROR);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getContractByNumber(int $contractNumber, bool $ignoreObjects = false): Contract
    {
        $statement = $this->getPdoDriver()->prepare('CALL GetContractByNumber(:contractNumber)');
        $statement->execute(['contractNumber' => $contractNumber]);

        $rawContractData = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        if (empty($rawContractData)) {
            throw new ContractNotFoundException();
        }

        $contractData = reset($rawContractData);
        if (!$ignoreObjects) {
            $this->enrichContractWithObjects($contractNumber, $contractData);
        }

        return $this->getMapper()->createContract($contractData);
    }

    /**
     * @inheritDoc
     */
    public function terminateContractByNumber(int $contractNumber, string $date): bool
    {
        $statement = $this->getPdoDriver()->prepare('CALL TerminateContractByNumber(:contractNumber, :date)');
        $result = $statement->execute([
            'contractNumber' => $contractNumber,
            'date' => $date,
        ]);

        $statement->closeCursor();

        if (true !== $result) {
            throw new ContractCanNotBeTerminatedException();
        }

        return true;
    }

    /**
     * @param int $contractNumber
     * @param array $rawContractData
     * @throws DatabaseUnreachableException
     * @throws ObjectNotFoundException
     * @throws RisksNotFoundException
     */
    private function enrichContractWithObjects(int $contractNumber, array &$rawContractData): void
    {
        $statement = $this->getPdoDriver()->prepare('CALL GetObjectsByContractNumber(:contractNumber)');
        $statement->execute(['contractNumber' => $contractNumber]);

        $rawObjectData = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        if (empty($rawContractData)) {
            throw new ObjectNotFoundException();
        }

        foreach ($rawObjectData as &$rawObject) {
            $this->enrichObjectWithRisks($rawObject);
        }

        $rawContractData['objects'] = $rawObjectData;
    }

    /**
     * @param array $object
     * @throws DatabaseUnreachableException
     * @throws RisksNotFoundException
     */
    private function enrichObjectWithRisks(array &$object): void
    {
        $statement = $this->getPdoDriver()->prepare('CALL GetRisksByObjectId(:objectId)');
        $statement->execute(['objectId' => $object['object_id']]);

        $rawRiskData = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        if (empty($rawRiskData)) {
            throw new RisksNotFoundException();
        }

        $object['risks'] = $rawRiskData;
    }

    /**
     * @return Mapper
     */
    private function getMapper(): Mapper
    {
        return $this->mapper;
    }

    /**
     * @param PDO $pdo
     */
    public function setPdoDriver(PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

    /**
     * @return PDO
     * @throws DatabaseUnreachableException
     * @codeCoverageIgnore
     */
    private function getPdoDriver(): PDO
    {
        if (null === $this->pdo) {
            $host = getenv('MARIADB_HOST');
            $user = getenv('MARIADB_USER');
            $password = getenv('MARIADB_PASSWORD');
            $name = getenv('MARIADB_NAME');
            $port = getenv('MARIADB_PORT');

            if (empty($host) || empty($user) || empty($password) || empty($name) || empty($port)) {
                throw new DatabaseUnreachableException();
            }

            $pdo = new PDO("mysql:dbname=$name;host=$host;port=$port;charset=utf8mb4", $user, $password, [
                PDO::ATTR_TIMEOUT => self::DATABASE_CONNECTION_TIMEOUT
            ]);

            $this->setPdoDriver($pdo);
        }

        return $this->pdo;
    }
}
