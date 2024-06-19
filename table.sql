CREATE DATABASE customer_accounts;

USE customer_accounts;

CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    company_name VARCHAR(255),
    position VARCHAR(255),
    phone1 VARCHAR(11),
    phone2 VARCHAR(11),
    phone3 VARCHAR(11)
);

-- Открой терминал и введи: 
-- mysql -u root -p
-- source table.sql;

-- Таким образом ты создал бд customer_accounts и таблицу accounts

