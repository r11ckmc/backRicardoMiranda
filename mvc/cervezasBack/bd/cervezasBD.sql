CREATE DATABASE cervezas_db;
USE cervezas_db;

CREATE TABLE cervezas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    ml INT NOT NULL,
    habilitado TINYINT(1) DEFAULT 1,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO cervezas (nombre, marca, ml) VALUES
('Corona Extra', 'Corona', 355),
('Heineken', 'Heineken', 500),
('victoria laton', 'corona', 440),
('tecate roja', 'roja', 355);
