<?php

namespace App\Tests\Mapper;

use App\Mapper\MariaDbMapper;
use App\Tests\TestCaseHelper;

class MariaDbMapperTest extends TestCaseHelper
{
    public function test_Mapper(): void
    {
        $mapper = new MariaDbMapper();
        $contract = $mapper->createContract($this->getRawData());

        $this->assertContract($contract);
        $this->assertPaymentAccount($contract->getPaymentAccount());
        $this->assertCustomer($contract->getCustomer());
        $this->assertObjects($contract->getObjects());
    }

    /**
     * @return array
     */
    private function getRawData(): array
    {
        $contract = $this->getRawContractData();
        $contract['objects'] = [];
        $contract['objects'][] = $this->getRawObjectData();
        $contract['objects'][0]['risks'] = $this->getRawRiskData();

        return reset($contract);
    }
}