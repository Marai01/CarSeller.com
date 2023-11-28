DROP DATABASE IF EXISTS CarSeller;
CREATE DATABASE CarSeller;
USE CarSeller;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) UNIQUE NOT NULL,
    password VARCHAR(200) NOT NULL
);

CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255) NOT NULL,
    prijs VARCHAR(30) NOT NULL,
    merk VARCHAR(255) NOT NULL,
    bouwjaar VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    km VARCHAR(255) NOT NULL,
    brandstof VARCHAR(255) NOT NULL,
    transmissie VARCHAR(255) NOT NULL,
    vermogen VARCHAR(255) NOT NULL,
    beschrijving TEXT NOT NULL,
    image LONGBLOB,
    user_id INT NOT NULL, 
    username VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE image (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    car_id INT,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
);

INSERT INTO `users` (`username`, `password`) VALUES
('admin', 'admin'),
('marai', 'marai');

INSERT INTO `cars` (
    `id`,
    `naam`,
    `prijs`,
    `merk`,
    `bouwjaar`,
    `model`,
    `km`,
    `brandstof`,
    `transmissie`,
    `vermogen`,
    `beschrijving`,
    `user_id`
)
VALUES
('',
 'Seat Leon FR',
 '€40.000',
 'Seat',
 '2018',
 'Station',
 '75.000',
 'Gasoline',
 'Automatic',
 '240PK',
 'Seat Leon FR from 2018. Always well maintained with panoramic roof.',
 1),
('',
 'Bmw M3 Touring',
 '€150.000',  
 'Bmw',
 '2023',
 'Touring',
 '200',
 'Gasoline',
 'Automatic',
 '550PK',
 'The new BMW M3 Touring with no less than 510 HP is the ideal family car.',
 2);