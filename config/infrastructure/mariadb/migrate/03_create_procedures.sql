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

         ,customer.firstname AS firstname
         ,customer.lastname AS lastname
         ,customer.age AS age
         ,customer.gender AS gender

         ,address.street AS street
         ,address.house_number AS house_number
         ,address.postcode AS postcode
         ,address.city AS city
         ,address.country AS country

         ,payment_account.holder AS payment_account_holder
         ,payment_account.iban AS payment_account_iban
         ,payment_account.bic AS payment_account_bic
         ,payment.description AS payment_name
    FROM conf_payment_account AS payment_account
         INNER JOIN contract AS contract
            ON payment_account.id = contract.payment_account_id
         INNER JOIN customer AS customer
            ON customer.id = contract.customer_id
         INNER JOIN address AS address
            ON address.id = customer.address_id
         INNER JOIN conf_payment AS payment
            ON payment.id = payment_account.payment_id
    WHERE contract.number = _contractNumber;
END //
DELIMITER ;

/**********************************************************************************************************************/

DELIMITER //
CREATE PROCEDURE GetObjectsByContractNumber (
    IN _contractNumber SMALLINT UNSIGNED
)
BEGIN
    SELECT
          object.object_id
         ,object.contract_id
         ,object.serial_number
         ,object.price
         ,object.currency
         ,object.description
         ,object.buying_date
         ,object.start_date
         ,object.end_date
         ,object.termination_date
    FROM contract AS contract
         INNER JOIN object AS object
            ON object.contract_id = contract.id
    WHERE contract.number = _contractNumber;
END //
DELIMITER ;

/**********************************************************************************************************************/

DELIMITER //
CREATE PROCEDURE GetRisksByObjectId (
    IN _objectId SMALLINT UNSIGNED
)
BEGIN
    SELECT
         mapping.object_id
        ,risks.name
    FROM risk_mapping AS mapping
         INNER JOIN conf_risks AS risks
            ON risks.id = mapping.risk_id
    WHERE mapping.object_id = _objectId;
END //
DELIMITER ;

/**********************************************************************************************************************/

DELIMITER //
CREATE PROCEDURE TerminateContractByNumber (
    IN _contractNumber SMALLINT UNSIGNED,
    IN _terminationDate DATE
)
BEGIN
    UPDATE contract
    SET termination_date = _terminationDate
    WHERE number = _contractNumber;
END //
DELIMITER ;

/**********************************************************************************************************************/

DELIMITER //
CREATE PROCEDURE BookRisk (
    IN _objectId SMALLINT UNSIGNED,
    IN _riskType SMALLINT UNSIGNED
)
BEGIN
    INSERT INTO risk_mapping (
         object_id
        ,risk_id
    )
    VALUES (
        _objectId
       ,_riskType
    );
END //
DELIMITER ;

/**********************************************************************************************************************/