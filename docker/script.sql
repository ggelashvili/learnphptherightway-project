CREATE TABLE
    transactions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        date DATE NOT NULL,
        check_number VARCHAR(10),
        description VARCHAR(255) NOT NULL,
        amount DECIMAL(10, 2) NOT NULL
    );