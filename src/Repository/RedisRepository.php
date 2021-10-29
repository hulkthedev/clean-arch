<?php

namespace App\Repository;

use App\Entity\Contract;
use App\Mapper\RedisMapper as Mapper;
use App\Repository\Exception\ContractNotFoundException;
use App\Repository\Exception\DatabaseUnreachableException;

class RedisRepository implements RepositoryInterface
{
    private Mapper $mapper;

    /**
     * @param Mapper $mapper
     * @throws DatabaseUnreachableException
     */
    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
        $this->filLDatabaseInFirstStart();
    }

    /**
     * @throws DatabaseUnreachableException
     */
    private function filLDatabaseInFirstStart(): void
    {
        $connection = $this->getConnection();
        if (false === $connection->get('1000')) {
            $contracts = [
                1000 => '{"id":1,"number":1000,"customerId":1,"requestDate":"2021-01-13","startDate":"2021-02-01","endDate":null,"terminationDate":null,"dunningLevel":0,"customer":{"firstname":"Bill","lastname":"Gates","age":72,"gender":"m","street":"Windows Ave.","houseNumber":"3422","postcode":"12F000","city":"Los Angeles","country":"USA"},"paymentAccount":{"name":"SEPA","holder":"Bill Gates","iban":"DE02500105170137075030","bic":"INGDDEFF","interval":30},"objects":[{"id":1,"serialNumber":"24235435436547456","price":1000,"currency":"USD","description":"Apple iPhone 11","buyingDate":"2021-01-01","startDate":"2021-02-01","endDate":null,"terminationDate":null,"risks":[{"name":"THEFT_PROTECTION_SMARTPHONE","type":1}]},{"id":2,"serialNumber":"47687987964564667","price":1600,"currency":"USD","description":"Samsung QLED 42 Zoll","buyingDate":"2021-05-13","startDate":"2021-06-01","endDate":null,"terminationDate":null,"risks":[{"name":"THEFT_PROTECTION_TV","type":2},{"name":"DAMAGE_PROTECTION_TV","type":5}]},{"id":2,"serialNumber":"34357769767435776","price":3500,"currency":"USD","description":"Samsung LCD 24 Zoll","buyingDate":"2021-10-07","startDate":"2021-11-01","endDate":null,"terminationDate":null,"risks":[{"name":"THEFT_PROTECTION_TV","type":2},{"name":"DAMAGE_PROTECTION_TV","type":5}]}]}',
                1001 => '{"id":2,"number":1001,"customerId":2,"requestDate":"2021-04-05","startDate":"2021-04-15","endDate":"2022-05-15","terminationDate":"2021-10-12","dunningLevel":0,"customer":{"firstname":"Elon","lastname":"Musk","age":45,"gender":"m","street":"Mars Main Street","houseNumber":"1","postcode":"55A111","city":"New York","country":"USA"},"paymentAccount":{"name":"SEPA","holder":"Elon Musk","iban":"DE02370502990000684712","bic":"COKSDE33","interval":15},"objects":[{"id":1,"serialNumber":"43575887089045546","price":400,"currency":"USD","description":"Samsung Galaxy S20","buyingDate":"2019-11-17","startDate":"2021-04-15","endDate":"2022-01-15","terminationDate":null,"risks":[{"name":"THEFT_PROTECTION_SMARTPHONE","type":1}]},{"id":4,"serialNumber":"08797685664345236","price":80,"currency":"EUR","description":"NAKUA Coffee 2000","buyingDate":"2017-07-03","startDate":"2021-04-15","endDate":"2022-01-15","terminationDate":null,"risks":[{"name":"THEFT_PROTECTION_OTHER","type":3},{"name":"DAMAGE_PROTECTION_OTHER","type":7}]}]}',
                1002 => '{"id":3,"number":1002,"customerId":3,"requestDate":"2021-05-20","startDate":"2021-06-01","endDate":"2021-12-01","terminationDate":"2021-07-01","dunningLevel":3,"customer":{"firstname":"Tom","lastname":"Hardy","age":37,"gender":"m","street":"Place de la R\u00c3\u00a9publique","houseNumber":"23a","postcode":"75000","city":"Paris","country":"France"},"paymentAccount":{"name":"PayPal","holder":"Tom Hardy","iban":null,"bic":null,"interval":30},"objects":[{"id":3,"serialNumber":"65477698708674545","price":4999,"currency":"EUR","description":"Alienware R5000","buyingDate":"2021-03-13","startDate":{"date":"2021-06-01","endDate":"2021-12-01","terminationDate":null,"risks":[{"name":"DAMAGE_PROTECTION_PC","type":6}]}]}',
                1003 => '{"id":4,"number":1003,"customerId":4,"requestDate":"2021-10-03","startDate":null,"endDate":null,"terminationDate":null,"dunningLevel":0,"customer":{"firstname":"Henry","lastname":"Ford","age":94,"gender":"m","street":"Hildesheimerstrasse","houseNumber":"144","postcode":"30179","city":"Hannover","country":"Germany"},"paymentAccount":{"name":"PayPal","holder":"Henry Ford","iban":null,"bic":null,"interval":30},"objects":[{"id":1,"serialNumber":"45465687685675576","price":800,"currency":"EUR","description":"Huawei P40+","buyingDate":"2019-07-05","startDate":null,"endDate":null,"terminationDate":null,"risks":[{"name":"THEFT_PROTECTION_SMARTPHONE","type":1}]},{"id":2,"serialNumber":"45654633454445455","price":1300,"currency":"EUR","description":"Samsung LCD 72 Zoll","buyingDate":"2020-01-15","startDate":null,"endDate":null,"terminationDate":null,"risks":[{"name":"THEFT_PROTECTION_TV","type":2},{"name":"DAMAGE_PROTECTION_TV","type":5}]},{"id":3,"serialNumber":"23543656768798787","price":1570,"currency":"USD","description":"Dell Game Station X","buyingDate":"2021-01-07","startDate":null,"endDate":null,"terminationDate":null,"risks":[{"name":"DAMAGE_PROTECTION_PC","type":6}]},{"id":4,"serialNumber":"34554688797877886","price":400,"currency":"EUR","description":"JURA C44-F","buyingDate":"2021-07-10","startDate":null,"endDate":null,"terminationDate":null,"risks":[{"name":"THEFT_PROTECTION_OTHER","type":3},{"name":"DAMAGE_PROTECTION_OTHER","type":7}]}]}',
            ];

            foreach ($contracts as $contractNumber => $contract) {
                $this->getConnection()->set($contractNumber, $contract);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getContractByNumber(int $contractNumber, bool $ignoreObjects = false): Contract
    {
        $redis = $this->getConnection();
        $rawContractData = $redis->get($contractNumber);

        $redis->close();

        if (empty($rawContractData)) {
            throw new ContractNotFoundException();
        }

        $contractData = json_decode($rawContractData, true);
        if ($ignoreObjects) {
            $contractData['objects'] = [];
        }

        return $this->getMapper()->createContract($contractData);
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
     * @return \Redis
     * @throws DatabaseUnreachableException
     * @codeCoverageIgnore
     */
    private function getConnection(): \Redis
    {
        $host = getenv('REDIS_HOST');
        $port = getenv('REDIS_PORT');

        if (empty($host) || empty($port)) {
            throw new DatabaseUnreachableException();
        }

        $redis = new \Redis();
        $redis->connect($host, $port);

        return $redis;
    }
}
