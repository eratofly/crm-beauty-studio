USE `crm-beauty-parlor`;

CREATE TABLE `stylist` (
    `id` int NOT NULL AUTO_INCREMENT,
    `first_name` varchar(50) NOT NULL,
    `last_name` varchar(50) NOT NULL,
    `phone` varchar(50) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `client` (
    `id` int NOT NULL AUTO_INCREMENT,
    `first_name` varchar(50) NOT NULL,
    `last_name` varchar(50) NOT NULL,
    `phone` varchar(50) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `appointment` (
    `id` int NOT NULL AUTO_INCREMENT,
    `date` DATETIME NOT NULL,
    `stylist_id` int NOT NULL,
    `client_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `appointment_stylist_id_fk` (`stylist_id`),
    KEY `appointment_client_id_fk` (`client_id`),
    CONSTRAINT `appointment_client_id_fk` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
    CONSTRAINT `appointment_barber_id_fk` FOREIGN KEY (`stylist_id`) REFERENCES `stylist` (`id`)
);

show tables;