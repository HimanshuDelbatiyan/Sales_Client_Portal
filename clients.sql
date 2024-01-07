
-- Name: - Himanshu
-- Student ID:   - 100898751
-- file name: - clients.sql
-- Folder name: - Lab01


DROP TABLE IF EXISTS clients;


CREATE TABLE clients
(
    clientid varchar(10) primary key,
    firstName varchar(50) not null,
    lastName varchar(40) not null,
    phoneNumber int not null,
    emailAddress varchar(50) not null,
    created_by_userID varchar(20) not null,
    logo_path varchar(180) not null
);

INSERT INTO clients 
VALUES
('AS001', 'Michael', 'Daloni', '89756', 'DaloniM@gmail.com', '4', '../Lab03/includes/image/Login.png'),
('AS002', 'Jennifer', 'Smith', '12345', 'jennsmith@gmail.com', '5', '../Lab03/includes/image/Login.png'),
('AS003', 'John', 'Doe', '67890', 'johndoe@gmail.com', '6', '../Lab03/includes/image/Login.png'),
('AS004', 'Alice', 'Johnson', '55555', 'alice.johnson@gmail.com', '1', '../Lab03/includes/image/Login.png'),
('AS005', 'Bob', 'Johnson', '44444', 'bob.johnson@gmail.com', '2', '../Lab03/includes/image/Login.png'),
('AS010', 'Bob', 'Johnson', '44444', 'bob.johnson@gmail.com', '2', '../Lab03/includes/image/Login.png'),
('AS011', 'Sarah', 'Miller', '78901', 'sarah.miller@gmail.com', '3', '../Lab03/includes/image/Login.png'),
('AS012', 'David', 'Williams', '45678', 'david.williams@gmail.com', '7', '../Lab03/includes/image/Login.png'),
('AS013', 'Emily', 'Jones', '23456', 'emily.jones@gmail.com', '4', '../Lab03/includes/image/Login.png'),
('AS014', 'Andrew', 'Clark', '56789', 'andrew.clark@gmail.com', '5', '../Lab03/includes/image/Login.png'),
('AS015', 'Olivia', 'White', '89012', 'olivia.white@gmail.com', '6', '../Lab03/includes/image/Login.png'),
('AS016', 'James', 'Johnson', '12345', 'james.johnson@gmail.com', '1', '../Lab03/includes/image/Login.png'),
('AS017', 'Sophia', 'Lee', '67890', 'sophia.lee@gmail.com', '2', '../Lab03/includes/image/Login.png'),
('AS018', 'Daniel', 'Smith', '55555', 'daniel.smith@gmail.com', '4', '../Lab03/includes/image/Login.png'),
('AS019', 'Ava', 'Brown', '44444', 'ava.brown@gmail.com', '5', '../Lab03/includes/image/Login.png'),
('AS020', 'Ethan', 'Martin', '33333', 'ethan.martin@gmail.com', '6', '../Lab03/includes/image/Login.png'),
('AS021', 'Emma', 'Anderson', '12345', 'emma.anderson@gmail.com', '7', '../Lab03/includes/image/Login.png'),
('AS022', 'Noah', 'Garcia', '45678', 'noah.garcia@gmail.com', '3', '../Lab03/includes/image/Login.png'),
('AS023', 'Avery', 'Taylor', '78901', 'avery.taylor@gmail.com', '2', '../Lab03/includes/image/Login.png'),
('AS024', 'Sophie', 'Thomas', '23456', 'sophie.thomas@gmail.com', '6', '../Lab03/includes/image/Login.png'),
('AS025', 'Jackson', 'Harris', '56789', 'jackson.harris@gmail.com', '1', '../Lab03/includes/image/Login.png'),
('AS026', 'Mia', 'Martinez', '89012', 'mia.martinez@gmail.com', '4', '../Lab03/includes/image/Login.png'),
('AS027', 'Elijah', 'Johnson', '11111', 'elijah.johnson@gmail.com', '5', '../Lab03/includes/image/Login.png'),
('AS028', 'Grace', 'Davis', '22222', 'grace.davis@gmail.com', '4', '../Lab03/includes/image/Login.png'),
('AS029', 'Liam', 'Moore', '33333', 'liam.moore@gmail.com', '5', '../Lab03/includes/image/Login.png'),
('AS030', 'Lily', 'Brown', '44444', 'lily.brown@gmail.com', '6', '../Lab03/includes/image/Login.png'),
('AS031', 'Owen', 'Anderson', '98765', 'owen.anderson@gmail.com', '3', '../Lab03/includes/image/Login.png'),
('AS032', 'Isabella', 'Garcia', '45612', 'isabella.garcia@gmail.com', '7', '../Lab03/includes/image/Login.png'),
('AS033', 'Logan', 'Taylor', '78909', 'logan.taylor@gmail.com', '2', '../Lab03/includes/image/Login.png'),
('AS034', 'Aria', 'Thomas', '23409', 'aria.thomas@gmail.com', '6', '../Lab03/includes/image/Login.png'),
('AS035', 'Carter', 'Harris', '56734', 'carter.harris@gmail.com', '1', '../Lab03/includes/image/Login.png'),
('AS036', 'Ava', 'Martinez', '89045', 'ava.martinez@gmail.com', '4', '../Lab03/includes/image/Login.png'),
('AS037', 'Mason', 'Johnson', '11156', 'mason.johnson@gmail.com', '5', '../Lab03/includes/image/Login.png'),
('AS038', 'Sofia', 'Davis', '22267', 'sofia.davis@gmail.com', '4', '../Lab03/includes/image/Login.png'),
('AS039', 'Ethan', 'Moore', '33378', 'ethan.moore@gmail.com', '5', '../Lab03/includes/image/Login.png'),
('AS040', 'Lily', 'Brown', '44489', 'lily.brown@gmail.com', '6', '../Lab03/includes/image/Login.png'),
('AS041', 'Oliver', 'Wilson', '55500', 'oliver.wilson@gmail.com', '1', '../Lab03/includes/image/Login.png'),
('AS042', 'Charlotte', 'Baker', '66611', 'charlotte.baker@gmail.com', '2', '../Lab03/includes/image/Login.png'),
('AS043', 'Lucas', 'Evans', '77722', 'lucas.evans@gmail.com', '3', '../Lab03/includes/image/Login.png'),
('AS044', 'Amelia', 'King', '88833', 'amelia.king@gmail.com', '4', '../Lab03/includes/image/Login.png'),
('AS045', 'Henry', 'Ward', '99944', 'henry.ward@gmail.com', '5', '../Lab03/includes/image/Login.png'),
('AS046', 'Layla', 'Cooper', '10055', 'layla.cooper@gmail.com', '6', '../Lab03/includes/image/Login.png'),
('AS047', 'Liam', 'Fisher', '11166', 'liam.fisher@gmail.com', '7', '../Lab03/includes/image/Login.png'),
('AS048', 'Zoe', 'Gomez', '12277', 'zoe.gomez@gmail.com', '1', '../Lab03/includes/image/Login.png'),
('AS049', 'Elijah', 'Cruz', '13388', 'elijah.cruz@gmail.com', '2', '../Lab03/includes/image/Login.png'),
('AS050', 'Avery', 'Lopez', '14499', 'avery.lopez@gmail.com', '3', '../Lab03/includes/image/Login.png');


