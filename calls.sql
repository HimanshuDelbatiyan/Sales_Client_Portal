-- Name: - Himanshu
-- Student ID:   - 100898751
-- file name: - calls.sql
-- Folder name: - Lab01

DROP  table IF EXISTS calls; -- drop table if exists


-- Table Creation
CREATE TABLE calls 
(
    clientid varchar(10),
    foreign key (clientid) references clients(clientid),
    calltime TIMESTAMP not null
);
