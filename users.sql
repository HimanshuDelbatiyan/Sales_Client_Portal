-- Name: - Himanshu
-- Student ID:  - 100898751
-- File name: - users.sql
-- Folder name: - Lab01 


-- Drop the table if exists !
DROP TABLE IF EXISTS users;

-- Creating the instance of the pgcrypto !
CREATE EXTENSION IF NOT EXISTS pgcrypto;


-- Create the users table
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    user_email VARCHAR(255)  UNIQUE NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- DEFAULT constraint is used !
    last_login_time TIMESTAMP DEFAULT Null,
    phone_extension VARCHAR(10),
    user_type CHAR(1),
    user_status varchar(10)
);

-- Inserting the data into the table 
INSERT INTO users (user_email, first_name, last_name, password_hash, phone_extension, user_type,user_status)
VALUES                                                  -- This function used "Blowfish crypt algorithm" For password hashing includn!
    ('himanshuSherawat@jat.com', 'Himanshu', 'Sherawat', crypt('Himanshu123@', gen_salt('bf')), '9896', 'A','active'), -- Himanshu123@
     ('clint@dcmail.com', 'Clint', 'Macdonald', crypt('Clint89', gen_salt('bf')), '5678', 'A','active'), -- Clint89
    ('harry@dcmail.com', 'Harry', 'Johnson', crypt('Harry89', gen_salt('bf')), '91011', 'A','active'), -- Harry89
    ('partikaRanjha@gmail.com', 'Partika', 'Ranjha', crypt('Ranjha123@', gen_salt('bf')), '9896', 'S','active'), -- Ranjha123@
     ('divya@dcmail.com', 'Divya', 'Sandhu', crypt('$32@', gen_salt('bf')), '5678', 'S','active'), -- $32@
    ('Sawn@dcmail.com', 'Sawn', 'Thompson', crypt('273#@', gen_salt('bf')), '91011', 'S','active'); -- 273#@