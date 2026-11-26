CREATE DATABASE IF NOT EXISTS `location_velo`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `location_velo`;

CREATE TABLE IF NOT EXISTS `users`(
`user_id` INT AUTO_INCREMENT,
`firstname` VARCHAR(255) NOT NULL,
`lastname` VARCHAR(255) NOT NULL,
`login` VARCHAR(100) NOT NULL,
`password` VARCHAR(255),
`role` ENUM('admin', 'employee') NOT NULL DEFAULT 'employee',
PRIMARY KEY(`user_id`),
UNIQUE(`login`)
);

CREATE TABLE IF NOT EXISTS `bikes`(
`bike_id` INT AUTO_INCREMENT,
`registration_number` VARCHAR(50) NOT NULL,
`availability` BOOLEAN,
`photo` VARCHAR(255),
PRIMARY KEY(`bike_id`)
);

CREATE TABLE IF NOT EXISTS `reservations`(
`user_id` INT,
`bike_id` INT,
`res_num` INT,
`res_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
`start_date` DATETIME NOT NULL,
`end_date` DATETIME NOT NULL,
`status` ENUM('pending', 'accepted', 'rejected') NOT NULL DEFAULT 'pending',
PRIMARY KEY(`user_id`, `bike_id`),
UNIQUE(`res_num`),
FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`),
FOREIGN KEY(`bike_id`) REFERENCES `bikes`(`bike_id`)
);