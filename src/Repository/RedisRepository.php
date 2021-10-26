<?php

namespace App\Repository;

use App\Entity\Contract;
use App\Mapper\RedisMapper as Mapper;
use App\Repository\Exception\DatabaseUnreachableException;
use Redis;

class RedisRepository
{
    private Mapper $mapper;
    private Redis $redis;

    /**
     * @param Mapper $mapper
     */
    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
        $this->filLDatabaseInFirstStart();
    }

    private function filLDatabaseInFirstStart(): void
    {
        $contracts = [
            '',
            '',
            '',
            '',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getContractByNumber(int $contractNumber, bool $ignoreObjects = false): Contract
    {

    }

    /**
     * @inheritDoc
     */
    public function terminateContractByNumber(int $contractNumber, string $date): bool
    {
        /**
         * @todo WIP
         */
        return true;
    }

    /**
     * @inheritDoc
     */
    public function bookRisk(int $objectId, int $riskType): bool
    {
        /**
         * @todo WIP
         */
        return true;
    }

    /**
     * @return Mapper
     */
    private function getMapper(): Mapper
    {
        return $this->mapper;
    }

    /**
     * @param Redis $redis
     */
    public function setRedisConnection(Redis $redis): void
    {
        $this->redis = $redis;
    }

    /**
     * @return Redis
     * @throws DatabaseUnreachableException
     * @codeCoverageIgnore
     */
    private function getConnection(): Redis
    {
        if (null === $this->redis) {
            $host = getenv('REDIS_HOST');
            $port = getenv('REDIS_PORT');

            if (empty($host) || empty($port)) {
                throw new DatabaseUnreachableException();
            }

            $redis = new Redis();
            $redis->connect($host, $port);

            $this->setRedisConnection($redis);
        }

        return $this->redis;
    }
}
