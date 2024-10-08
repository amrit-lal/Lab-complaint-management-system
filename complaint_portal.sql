CREATE DATABASE IF NOT EXISTS complaint_portal;
USE complaint_portal;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    user_type ENUM('student', 'HOD', 'supervisor', 'admin') NOT NULL,
    department VARCHAR(50) DEFAULT NULL
);

CREATE TABLE complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    title VARCHAR(100),
    pc_number VARCHAR(30),
    room_number VARCHAR(255),
    components VARCHAR(200),
    description TEXT,
    status ENUM('pending', 'verified', 'resolved') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL
    
);
ALTER TABLE complaints
ADD CONSTRAINT fk_student
FOREIGN KEY (student_id) REFERENCES users(id);