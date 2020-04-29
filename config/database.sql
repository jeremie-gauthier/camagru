DROP DATABASE IF EXISTS camagrudb;
CREATE DATABASE camagrudb;
USE camagrudb;

-- TABLES

CREATE TABLE users (
  idUsers INT UNSIGNED AUTO_INCREMENT,
  pseudo VARCHAR(16) NOT NULL,
  email TINYTEXT NOT NULL,
  password TINYTEXT NOT NULL,
  secureHash TINYTEXT,
  regDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (idUsers)
) ENGINE='InnoDB';

CREATE TABLE pictures (
  idPictures INT UNSIGNED AUTO_INCREMENT,
  diUsers INT NOT NULL,
  encoding MEDIUMTEXT NOT NULL,
  legend TINYTEXT,
  regDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (idPictures)
) ENGINE='InnoDB';

CREATE TABLE likes (
  diUsers INT NOT NULL,
  diPictures INT NOT NULL,
  PRIMARY KEY (diUsers, diPictures)
) ENGINE='InnoDB';

CREATE TABLE comments (
  idComments INT UNSIGNED AUTO_INCREMENT,
  diUsers INT NOT NULL,
  diPictures INT NOT NULL,
  comment TINYTEXT NOT NULL,
  regDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (idComments) 
) ENGINE='InnoDB';

-- TRIGGERS

CREATE TRIGGER beforeDeleteUsers
BEFORE DELETE ON users
FOR EACH ROW
BEGIN
  DELETE FROM pictures WHERE diUsers = OLD.idUsers;
  DELETE FROM likes WHERE diUsers = OLD.idUsers;
  DELETE FROM comments WHERE diUsers = OLD.idUsers;
END ;

CREATE TRIGGER beforeDeletePictures
BEFORE DELETE ON pictures
FOR EACH ROW
BEGIN
  DELETE FROM likes WHERE diPictures = OLD.idPictures;
  DELETE FROM comments WHERE diPictures = OLD.idPictures;
END ;
