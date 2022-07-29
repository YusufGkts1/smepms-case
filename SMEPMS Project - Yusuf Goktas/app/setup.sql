CREATE DATABASE `smepms`;
USE `smepms`;
CREATE TABLE `boxes`(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(64) NOT NULL,
    `width` FLOAT NOT NULL,
    `height` FLOAT NOT NULL,
    `length` FLOAT NOT NULL,
    `created_on` DATETIME NOT NULL,
    `updated_on` DATETIME NOT NULL
    );
