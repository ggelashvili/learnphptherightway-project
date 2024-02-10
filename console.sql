USE my_db;

CREATE TABLE transactions
(
    id          INT PRIMARY KEY AUTO_INCREMENT,
    date        DATE           NOT NULL,
    `check`     TINYINT,
    description VARCHAR(30)    NOT NULL,
    amount      DECIMAL(10, 2) NOT NULL,
    KEY `date` (date),
    KEY `amount` (amount)
);

DESCRIBE transactions;