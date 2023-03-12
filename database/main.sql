CREATE DATABASE IF NOT EXISTS oops_project_db;

use oops_project_db;

CREATE TABLE IF NOT EXISTS transactions(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    created_on DATE NOT NULL,
    check_number INT(11),
    description VARCHAR(100) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL
);
