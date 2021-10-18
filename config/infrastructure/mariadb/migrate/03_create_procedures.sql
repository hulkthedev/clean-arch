use ca_example;

/**********************************************************************************************************************/
DELIMITER //
CREATE PROCEDURE GetContractByNumber (
    IN _contractNumber SMALLINT UNSIGNED
)
BEGIN
    SELECT
          contract.id
         ,contract.number
         ,contract.customer_id
         ,contract.request_date
         ,contract.start_date
         ,contract.end_date
         ,contract.termination_date
         ,contract.dunning_level
         ,contract.payment_interval
         ,contract.payment_account_id

         ,payment_account.holder AS payment_account_holder
         ,payment_account.iban AS payment_account_iban
         ,payment_account.bic AS payment_account_bic

         ,customer.firstname AS customer_firstname
         ,customer.lastname AS customer_lastname
         ,customer.age AS customer_age
         ,customer.gender AS customer_gender
         ,address.street AS customer_street
         ,address.house_number AS customer_house_number
         ,address.postcode AS customer_postcode
         ,address.city AS customer_city
         ,address.country AS customer_country

         ,object.objects_id AS object_id
         ,object.serial_number AS object_serial_no
         ,object.price AS object_price
         ,object.currency AS object_currency
         ,object.buying_date AS object_buying_date
         ,object.start_date AS object_start_date
         ,object.end_date AS object_end_date
         ,object.termination_date AS object_termination_date

    FROM conf_payment_account AS payment_account
         INNER JOIN contract AS contract
            ON payment_account.id = contract.payment_account_id

         INNER JOIN customer AS customer
            ON customer.id = contract.customer_id

         INNER JOIN address AS address
            ON address.id = customer.address_id

         INNER JOIN object AS object
            ON object.contract_id = contract.id
    WHERE contract.number = _contractNumber;
END //
DELIMITER ;
/**********************************************************************************************************************/