use ca_example;

/**********************************************************************************************************************/
DELIMITER //
CREATE PROCEDURE GetContractById (
    IN _contractId SMALLINT UNSIGNED
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

    FROM conf_payment_account AS payment_account
         INNER JOIN contract AS contract
            ON payment_account.id = contract.payment_account_id

         INNER JOIN customer AS customer
            ON customer.id = contract.customer_id

         INNER JOIN address AS address
            ON address.id = customer.address_id
    WHERE contract.id = _contractId;
END //
DELIMITER ;
/**********************************************************************************************************************/