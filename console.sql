USE my_db;
DROP TABLE transactions;
CREATE TABLE transactions
(
    id           INT PRIMARY KEY AUTO_INCREMENT,
    date         DATE           NOT NULL,
    check_number SMALLINT,
    description  VARCHAR(30)    NOT NULL,
    amount       DECIMAL(10, 2) NOT NULL,
    KEY `date` (date),
    KEY `amount` (amount)
);

DESCRIBE transactions;

SELECT *
FROM transactions;