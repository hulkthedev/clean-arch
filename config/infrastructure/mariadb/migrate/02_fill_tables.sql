use ca_example;

INSERT INTO conf_objects
    (name, description)
VALUES
    ('SMARTPHONE', 'All Smartphones'),
    ('TV', 'All TVs'),
    ('COMPUTER', 'Computer'),
    ('COFFEE_MACHINE', 'Coffee machines');

INSERT INTO conf_payment
    (description)
VALUES
    ('None'),
    ('SEPA'),
    ('PayPal');

INSERT INTO conf_payment_account
    (payment_id, holder, iban, bic)
VALUES
    (2, 'Bill Gates', 'DE02500105170137075030', 'INGDDEFF'),
    (2, 'Elon Musk', 'DE02370502990000684712', 'COKSDE33'),
    (3, 'Tom Hardy', NULL, NULL),
    (3, 'Henry Ford', NULL, NULL);

INSERT INTO conf_risks
    (name, description)
VALUES
    ('THEFT_PROTECTIONS_SMARTPHONE', 'Theft Protection for Smartphones'),
    ('THEFT_PROTECTIONS_TV', 'Theft Protection for TVs'),
    ('THEFT_PROTECTIONS_OTHER', 'General theft Protection'),
    ('DAMAGE_PROTECTION_SMARTPHONE', 'Damage Protection for Smartphones'),
    ('DAMAGE_PROTECTION_TV', 'Damage Protection for TVs'),
    ('DAMAGE_PROTECTION_PC', 'Damage Protection for Computer'),
    ('DAMAGE_PROTECTION_OTHER', 'General Damage Protection');

INSERT INTO address
    (street, house_number, postcode, city, country)
VALUES
    ('Windows Ave.', '3422', '12F000', 'Los Angeles', 'USA'),
    ('Mars Main Street', '1', '55A111', 'New York', 'USA'),
    ('Place de la République', '23a', '75000', 'Paris', 'France'),
    ('Hildesheimerstrasse', '144', '30179', 'Hannover', 'Germany');

INSERT INTO customer
    (firstname, lastname, age, gender, address_id)
VALUES
    ('Bill', 'Gates', 72, 'm', 1),
    ('Elon', 'Musk', 45, 'm', 2),
    ('Tom', 'Hardy', 37, 'm', 3),
    ('Henry', 'Ford', 94, 'm', 4);

INSERT INTO contract
    (number, customer_id, request_date, start_date, end_date, termination_date, payment_interval, payment_account_id, dunning_level)
VALUES
    (1000, 1, '2021-01-13', '2021-02-01',  NULL,         NULL,        30, 1, 0),
    (1001, 2, '2021-04-05', '2021-04-15', '2022-05-15', '2021-10-12', 15, 2, 0),
    (1002, 3, '2021-05-20', '2021-06-01', '2021-12-01', '2021-07-01', 30, 3, 3),
    (1003, 4, '2021-10-03',  NULL,         NULL,         NULL,        40, 4, 0);

INSERT INTO object
    (contract_id, object_id, serial_number, price, currency, description, buying_date, start_date, end_date, termination_date)
VALUES
    (1, 1, '24235435436547456', '999.99', 'USD', 'Apple iPhone 11', '2021-01-01', '2021-02-01', NULL, NULL),
    (1, 2, '47687987964564667', '1599.79', 'USD', 'Samsung QLED 42 Zoll', '2021-05-13', '2021-06-01', NULL, NULL),
    (1, 2, '34357769767435776', '3500.00', 'USD', 'Samsung LCD 24 Zoll', '2021-10-07', '2021-11-01', NULL, NULL),

    (2, 1, '43575887089045546', '399.99', 'USD', 'Samsung Galaxy S20', '2019-11-17', '2021-04-15', '2022-01-15', NULL),
    (2, 4, '08797685664345236', '79.85', 'EUR', 'NAKUA Coffee 2000', '2017-07-03', '2021-04-15', '2022-01-15', NULL),

    (3, 3, '65477698708674545', '4999.00', 'EUR', 'Alienware R5000', '2021-03-13', '2021-06-01', '2021-12-01', NULL),

    (4, 1, '45465687685675576', '799.99', 'EUR', 'Huawei P40+', '2019-07-05', NULL, NULL, NULL),
    (4, 2, '45654633454445455', '1299.99', 'EUR', 'Samsung LCD 72 Zoll', '2020-01-15', NULL, NULL, NULL),
    (4, 3, '23543656768798787', '1570.00', 'USD', 'Dell Game Station X', '2021-01-07', NULL, NULL, NULL),
    (4, 4, '34554688797877886', '399.99', 'EUR', 'JURA C44-F', '2021-07-10', NULL, NULL, NULL);

INSERT INTO risk_mapping
    (object_id, risk_id)
VALUES
    (1, 1),
    (1, 4),
    (2, 2),
    (2, 5),
    (3, 6),
    (4, 3),
    (4, 7);