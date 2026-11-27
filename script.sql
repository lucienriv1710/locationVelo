CREATE DATABASE IF NOT EXISTS `location_velo`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `location_velo`;

CREATE TABLE IF NOT EXISTS `users` (
    `user_id` INT NOT NULL AUTO_INCREMENT,
    `firstname` VARCHAR(255) NOT NULL,
    `lastname` VARCHAR(255) NOT NULL,
    `login` VARCHAR(100) NOT NULL,
    `password` VARCHAR(255) DEFAULT NULL,
    `role` ENUM('admin', 'employee') NOT NULL DEFAULT 'employee',
    PRIMARY KEY (`user_id`),
    UNIQUE KEY `uq_users_login` (`login`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `bikes` (
    `bike_id` INT NOT NULL AUTO_INCREMENT,
    `registration_number` VARCHAR(50) NOT NULL,
    `availability` TINYINT(1) DEFAULT NULL,
    `photo` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`bike_id`),
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `reservations` (
    `res_id` INT NOT NULL AUTO_INCREMENT,
    `res_num` VARCHAR(20) NOT NULL,
    `bike_id` INT NOT NULL,
    `citizen_name` VARCHAR(255) NOT NULL,
    `citizen_email` VARCHAR(255) NOT NULL,
    `res_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `start_date` DATETIME NOT NULL,
    `end_date` DATETIME NOT NULL,
    `status` ENUM('pending', 'accepted', 'rejected') NOT NULL DEFAULT 'pending',
    `processed_by` INT DEFAULT NULL,
    PRIMARY KEY (`res_id`),
    UNIQUE KEY `uq_reservations_number` (`res_num`),
    KEY `idx_reservations_bike` (`bike_id`),
    KEY `idx_reservations_processed_by` (`processed_by`),
    CONSTRAINT `fk_reservations_bike` FOREIGN KEY (`bike_id`) REFERENCES `bikes` (`bike_id`),
    CONSTRAINT `fk_reservations_processed_by` FOREIGN KEY (`processed_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB;
