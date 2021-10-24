<?php


namespace App\Tests;

use App\Entity\Contract;
use App\Entity\Customer;
use App\Entity\ObjectItem;
use App\Entity\PaymentAccount;
use App\Entity\Risk;
use App\Tests\Entity\ContractStub;
use App\Tests\Entity\CustomerStub;
use App\Tests\Entity\ObjectItemStub;
use App\Tests\Entity\PaymentAccountStub;
use App\Tests\Entity\RiskStub;
use PHPUnit\Framework\TestCase;

class TestCaseHelper extends TestCase
{
    /**
     * @return array
     */
    protected function getRawContractData(): array
    {
        return [[
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
        ]];
    }

    /**
     * @return array
     */
    protected function getRawObjectData(): array
    {
        return [[
            'object_id' => 1,
            'contract_id' => 1,
            'serial_number' => '24235435436547456',
            'price' => 1000,
            'currency' => 'USD',
            'description' => 'Apple iPhone 11',
            'buying_date' => '2021-01-01',
            'start_date' => '2021-02-01',
            'end_date' => null,
            'termination_date' => null
        ]];
    }

    /**
     * @return array
     */
    protected function getRawRiskData(): array
    {
        return [[
            'object_id' => 1,
            'name' => 'THEFT_PROTECTION_SMARTPHONE'
        ]];
    }

    /**
     * @param Contract $contract
     */
    protected function assertContract(Contract $contract): void
    {
        $stub = new ContractStub();
        self::assertEquals($contract->id, $stub->id);
        self::assertEquals($contract->number, $stub->number);
        self::assertEquals($contract->customerId, $stub->customerId);
        self::assertEquals($contract->dunningLevel, $stub->dunningLevel);

        self::assertNotEmpty($contract->startDate);
        self::assertNotEmpty($contract->requestDate);
        self::assertNull($contract->endDate);
        self::assertNull($contract->terminationDate);

    }

    /**
     * @param PaymentAccount $paymentAccount
     */
    protected function assertPaymentAccount(PaymentAccount $paymentAccount): void
    {
        $stub = new PaymentAccountStub();
        self::assertEquals($paymentAccount->name, $stub->name);
        self::assertEquals($paymentAccount->holder, $stub->holder);
        self::assertEquals($paymentAccount->iban, $stub->iban);
        self::assertEquals($paymentAccount->bic, $stub->bic);
        self::assertEquals($paymentAccount->interval, $stub->interval);
    }

    /**
     * @param Customer $customer
     */
    protected function assertCustomer(Customer $customer): void
    {
        $stub = new CustomerStub();
        self::assertEquals($customer->firstname, $stub->firstname);
        self::assertEquals($customer->lastname, $stub->lastname);
        self::assertEquals($customer->age, $stub->age);
        self::assertEquals($customer->gender, $stub->gender);
        self::assertEquals($customer->street, $stub->street);
        self::assertEquals($customer->postcode, $stub->postcode);
        self::assertEquals($customer->city, $stub->city);
        self::assertEquals($customer->country, $stub->country);
    }

    /**
     * @param array $objects
     */
    protected function assertObjects(array $objects): void
    {
        $stub = new ObjectItemStub();

        /** @var ObjectItem $object */
        foreach ($objects as $object) {
            self::assertEquals($object->id, $stub->id);
            self::assertEquals($object->serialNumber, $stub->serialNumber);
            self::assertEquals($object->price, $stub->price);
            self::assertEquals($object->currency, $stub->currency);
            self::assertEquals($object->description, $stub->description);
            self::assertEquals($object->description, $stub->description);

            self::assertNotEmpty($object->buyingDate);
            self::assertNotEmpty($object->startDate);
            self::assertNull($object->endDate);
            self::assertNull($object->terminationDate);

            /** @var Risk $risk */
            foreach ($object->getRisks() as $riskName) {
                self::assertEquals($riskName, (new RiskStub())->name);
            }
        }
    }
}
