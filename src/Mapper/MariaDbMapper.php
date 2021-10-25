<?php

namespace App\Mapper;

use App\Entity\Contract;
use App\Entity\Customer;
use App\Entity\ObjectItem;
use App\Entity\PaymentAccount;
use App\Entity\Risk;
use DateTimeImmutable;

class MariaDbMapper
{
    /**
     * @param array $data
     * @return Contract
     */
    public function createContract(array $data): Contract
    {
        $contract = new Contract();
        $contract->id = $data['id'];
        $contract->number = $data['number'];
        $contract->customerId = $data['customer_id'];
        $contract->dunningLevel = $data['dunning_level'];

        $contract->requestDate = $this->checkOnDate($data['request_date']);
        $contract->startDate = $this->checkOnDate($data['start_date']);
        $contract->endDate = $this->checkOnDate($data['end_date']);
        $contract->terminationDate = $this->checkOnDate($data['termination_date']);

        $contract->customer = $this->createCustomer($data);
        $contract->paymentAccount = $this->createPaymentAccount($data);

        foreach ($data['objects'] as $object) {
            $contract->objects[] = $this->createObject($object);
        }

        return $contract;
    }

    /**
     * @param array $data
     * @return Customer
     */
    private function createCustomer(array $data): Customer
    {
        $customer = new Customer();
        $customer->firstname = $data['firstname'];
        $customer->lastname = $data['lastname'];
        $customer->age = $data['age'];
        $customer->gender = $data['gender'];
        $customer->street = $data['street'];
        $customer->houseNumber = $data['house_number'];
        $customer->postcode = $data['postcode'];
        $customer->city = $data['city'];
        $customer->country = $data['country'];

        return $customer;
    }

    /**
     * @param array $data
     * @return PaymentAccount
     */
    private function createPaymentAccount(array $data): PaymentAccount
    {
        $account = new PaymentAccount();
        $account->name = $data['payment_name'];
        $account->holder = $data['payment_account_holder'];
        $account->iban = $data['payment_account_iban'];
        $account->bic = $data['payment_account_bic'];
        $account->interval = $data['payment_interval'];

        return $account;
    }

    /**
     * @param array $data
     * @return ObjectItem
     */
    private function createObject(array $data): ObjectItem
    {
        $object = new ObjectItem();
        $object->id = $data['object_id'];
        $object->serialNumber = $data['serial_number'];
        $object->price = $data['price'];
        $object->currency = $data['currency'];
        $object->description = $data['description'];

        $object->buyingDate = $this->checkOnDate($data['buying_date']);
        $object->startDate = $this->checkOnDate($data['start_date']);
        $object->endDate = $this->checkOnDate($data['end_date']);
        $object->terminationDate = $this->checkOnDate($data['termination_date']);

        foreach ($data['risks'] as $riskData) {
            $risk = new Risk();
            $risk->name = $riskData['name'];

            $object->risks[] = $risk;
        }

        return $object;
    }

    /**
     * @param $value
     * @return DateTimeImmutable|null
     */
    private function checkOnDate($value): ?DateTimeImmutable
    {
        try {
            return new DateTimeImmutable($value ?? []);
        } catch (\Throwable $throwable) {
            return null;
        }
    }
}
