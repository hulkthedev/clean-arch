/** conf **/
CREATE TABLE conf_objects (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(25) NOT NULL,
    description VARCHAR(50) NOT NULL,

    CONSTRAINT unique_objects UNIQUE (name)
);

CREATE TABLE conf_payment (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(25) NOT NULL
);

CREATE TABLE conf_payment_account (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    payment_id SMALLINT UNSIGNED NOT NULL,
    holder VARCHAR(50) NOT NULL,
    iban VARCHAR(25) NULL,
    bic VARCHAR(20) NULL,

    CONSTRAINT fk_payment_id FOREIGN KEY (payment_id) REFERENCES conf_payment (id)
);

CREATE TABLE conf_risks (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(50) NOT NULL,

    CONSTRAINT unique_contract1 UNIQUE (name)
);

CREATE TABLE address (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    street VARCHAR(50) NOT NULL,
    house_number VARCHAR(5) NOT NULL,
    postcode VARCHAR(10) NOT NULL,
    city VARCHAR(50) NOT NULL,
    country VARCHAR(50) NOT NULL
);

CREATE TABLE customer (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    age SMALLINT NOT NULL,
    gender VARCHAR(1) NOT NULL,
    address_id SMALLINT UNSIGNED NOT NULL,

    CONSTRAINT unique_customer UNIQUE (firstname, lastname),
    CONSTRAINT fk_address_id FOREIGN KEY (address_id) REFERENCES address (id)
);

CREATE TABLE contract (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    number INT UNSIGNED NOT NULL,

    customer_id SMALLINT UNSIGNED NOT NULL,

    request_date DATE NOT NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    termination_date DATE NULL,

    dunning_level SMALLINT NOT NULL,

    payment_interval SMALLINT UNSIGNED NULL,
    payment_account_id SMALLINT UNSIGNED NOT NULL,

    CONSTRAINT unique_contract2 UNIQUE (number),
    CONSTRAINT fk_payment_account_id FOREIGN KEY (payment_account_id) REFERENCES conf_payment_account (id),
    CONSTRAINT fk_customer_id FOREIGN KEY (customer_id) REFERENCES customer (id)
);

CREATE TABLE object (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    object_id SMALLINT UNSIGNED NOT NULL,
    contract_id SMALLINT UNSIGNED NOT NULL,

    serial_number VARCHAR(50) NOT NULL,
    price INT NOT NULL,
    currency VARCHAR(25) NOT NULL,
    description VARCHAR(50) NOT NULL,

    buying_date DATE NOT NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    termination_date DATE NULL,

    CONSTRAINT fk_contract_id FOREIGN KEY (contract_id) REFERENCES contract (id),
    CONSTRAINT fk1_object_id FOREIGN KEY (object_id) REFERENCES conf_objects (id)
);

CREATE TABLE risk_mapping (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    object_id SMALLINT UNSIGNED NOT NULL,
    risk_id SMALLINT UNSIGNED NOT NULL,

    CONSTRAINT fk_risk_id FOREIGN KEY (risk_id) REFERENCES conf_risks (id),
    CONSTRAINT fk_2object_id FOREIGN KEY (object_id) REFERENCES object (id)
);
