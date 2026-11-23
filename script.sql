CREATE TABLE `users`(
   `user_id` INT AUTO_INCREMENT,
   `firstname` VARCHAR(255) NOT NULL,
   `lastname` VARCHAR(255) NOT NULL,
   `login` INT NOT NULL,
   `password` VARCHAR(80),
   PRIMARY KEY(`user_id`),
   UNIQUE(`login`)
);

CREATE TABLE `bikes`(
   `bike_id` INT AUTO_INCREMENT,
   `registration_number` VARCHAR(50) NOT NULL,
   `availability` BOOLEAN,
   `photo` VARCHAR(255),    
   PRIMARY KEY(`bike_id`)
);

CREATE TABLE reservations (
   `user_id` INT,
   `bike_id` INT,
   `res_num` INT,
   `res_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   `start_date` DATETIME NOT NULL,
   `end_date` DATETIME NOT NULL,
   status ENUM('pending', 'accepted', 'rejected') NOT NULL DEFAULT 'pending',
   PRIMARY KEY(`user_id`, `bike_id`),
   UNIQUE(`res_num`),
   FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`),
   FOREIGN KEY(`bike_id`) REFERENCES `bikes`(`bike_id`)
);
