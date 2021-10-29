<?php

namespace App\Mapper;

use App\Entity\Contract;
use App\Entity\Customer;
use App\Entity\ObjectItem;
use App\Entity\PaymentAccount;
use App\Entity\Risk;
use DateTimeImmutable;

class RedisMapper
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
        $contract->customerId = $data['customerId'];
        $contract->dunningLevel = $data['dunningLevel'];

        $contract->requestDate = $this->checkOnDate($data['requestDate']);
        $contract->startDate = $this->checkOnDate($data['startDate']);
        $contract->endDate = $this->checkOnDate($data['endDate']);
        $contract->terminationDate = $this->checkOnDate($data['terminationDate']);

        $contract->customer = $this->createCustomer($data);
        $contract->paymentAccount = $this->createPaymentAccount($data);

        if (isset($data['objects'])) {
            foreach ($data['objects'] as $object) {
                $contract->objects[] = $this->createObject($object);
            }
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
        $customer->firstname = $data['customer']['firstname'];
        $customer->lastname = $data['customer']['lastname'];
        $customer->age = $data['customer']['age'];
        $customer->gender = $data['customer']['gender'];
        $customer->street = $data['customer']['street'];
        $customer->houseNumber = $data['customer']['houseNumber'];
        $customer->postcode = $data['customer']['postcode'];
        $customer->city = $data['customer']['city'];
        $customer->country = $data['customer']['country'];

        return $customer;
    }

    /**
     * @param array $data
     * @return PaymentAccount
     */
    private function createPaymentAccount(array $data): PaymentAccount
    {
        $account = new PaymentAccount();
        $account->name = $data['paymentAccount']['name'];
        $account->holder = $data['paymentAccount']['holder'];
        $account->iban = $data['paymentAccount']['iban'];
        $account->bic = $data['paymentAccount']['bic'];
        $account->interval = $data['paymentAccount']['interval'];

        return $account;
    }

    /**
     * @param array $data
     * @return ObjectItem
     */
    private function createObject(array $data): ObjectItem
    {
        $object = new ObjectItem();
        $object->id = $data['id'];
        $object->serialNumber = $data['serialNumber'];
        $object->price = $data['price'];
        $object->currency = $data['currency'];
        $object->description = $data['description'];

        $object->buyingDate = $this->checkOnDate($data['buyingDate']);
        $object->startDate = $this->checkOnDate($data['startDate']);
        $object->endDate = $this->checkOnDate($data['endDate']);
        $object->terminationDate = $this->checkOnDate($data['terminationDate']);

        foreach ($data['risks'] as $riskData) {
            $risk = new Risk();
            $risk->name = $riskData['name'];
            $risk->type = Risk::getTypeByName($riskData['name']);

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
