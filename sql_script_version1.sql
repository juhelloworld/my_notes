SHOW databases;

CREATE DATABASE notes_project;

use notes_project;

show tables;

CREATE TABLE notes_table
(
note_id INT NOT NULL AUTO_INCREMENT , 
name TEXT NOT NULL , 
email VARCHAR(200) NOT NULL , 
category TEXT NOT NULL , 
note VARCHAR(2000) NOT NULL , 
time_of_note_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY (note_id)
);

desc notes_table;