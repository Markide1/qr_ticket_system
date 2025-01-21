CREATE DATABASE qr_ticket_system;
USE qr_ticket_system;

CREATE TABLE events (
    event_id INT PRIMARY KEY AUTO_INCREMENT,
    event_name VARCHAR(100) NOT NULL,
    event_date DATETIME NOT NULL,
    venue VARCHAR(100) NOT NULL
);

CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20)
);

CREATE TABLE tickets (
    ticket_id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT,
    user_id INT,
    payment_amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(event_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);