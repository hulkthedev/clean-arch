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
     * @todo auslagern und wiederverwenden
     * @return array
     */
    private function getRawData(): array
    {
        return [
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
            'objects' => [
                [
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
                    'risks' => [
                        [
                            'object_id' => 1,
                            'name' => 'THEFT_PROTECTION_SMARTPHONE'
                        ]
                    ]
                ]
            ]
        ];
    }
}