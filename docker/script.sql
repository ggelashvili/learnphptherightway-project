CREATE TABLE
    transactions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        date DATE NOT NULL,
        check_number INT,
        description VARCHAR(255) NOT NULL,
        amount DECIMAL(10, 2) NOT NULL
    );

INSERT INTO
    transactions (
        date,
        check_number,
        description,
        amount
    )
VALUES (
        '2021-05-01',
        NULL,
        'Transaction 2',
        700.25
    );

INSERT INTO
    transactions (
        date,
        check_number,
        description,
        amount
    )
VALUES (
        '2021-06-01',
        NULL,
        'Transaction 3',
        -1303.97
    );

INSERT INTO
    transactions (
        date,
        check_number,
        description,
        amount
    )
VALUES (
        '2021-07-01',
        NULL,
        'Transaction 4',
        46.78
    );

INSERT INTO
    transactions (
        date,
        check_number,
        description,
        amount
    )
VALUES (
        '2021-08-01',
        NULL,
        'Transaction 5',
        816.87
    );