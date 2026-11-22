CREATE DATABASE IF NOT EXISTS ecopoints CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ecopoints;
CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(120) NOT NULL, email VARCHAR(190) NOT NULL UNIQUE,
 student_id VARCHAR(60) UNIQUE NULL, password_hash VARCHAR(255) NOT NULL,
 role ENUM('student','personnel','admin') NOT NULL DEFAULT 'student',
 status ENUM('active','inactive') NOT NULL DEFAULT 'active', points_balance INT NOT NULL DEFAULT 0,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE stations (
 id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL, location VARCHAR(190) NOT NULL,
 qr_token VARCHAR(100) NOT NULL UNIQUE, active TINYINT(1) NOT NULL DEFAULT 1
);
CREATE TABLE material_categories (
 id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(120) NOT NULL, points INT NOT NULL DEFAULT 0,
 min_weight DECIMAL(8,2) NOT NULL DEFAULT 0, max_weight DECIMAL(8,2) NOT NULL DEFAULT 999,
 active TINYINT(1) NOT NULL DEFAULT 1
);
CREATE TABLE recycling_sessions (
 id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, station_id INT NOT NULL, material_id INT NOT NULL,
 status ENUM('active','verified','flagged','expired') NOT NULL DEFAULT 'active',
 weight_grams DECIMAL(8,2) NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(id), FOREIGN KEY(station_id) REFERENCES stations(id),
 FOREIGN KEY(material_id) REFERENCES material_categories(id)
);
CREATE TABLE sensor_readings (
 id INT AUTO_INCREMENT PRIMARY KEY, session_id INT NOT NULL, weight_grams DECIMAL(8,2) NOT NULL,
 received_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(session_id) REFERENCES recycling_sessions(id)
);
CREATE TABLE wallet_transactions (
 id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, points INT NOT NULL, description VARCHAR(190) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(user_id) REFERENCES users(id)
);
CREATE TABLE rewards (
 id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL, points_required INT NOT NULL,
 stock INT NOT NULL DEFAULT 0, active TINYINT(1) NOT NULL DEFAULT 1
);
CREATE TABLE redemptions (
 id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, reward_id INT NOT NULL, code VARCHAR(30) NOT NULL UNIQUE,
 status ENUM('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
 claimed_by INT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, claimed_at DATETIME NULL,
 FOREIGN KEY(user_id) REFERENCES users(id), FOREIGN KEY(reward_id) REFERENCES rewards(id),
 FOREIGN KEY(claimed_by) REFERENCES users(id)
);
CREATE TABLE activity_logs (
 id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NULL, action VARCHAR(190) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(user_id) REFERENCES users(id)
);

INSERT INTO stations(name,location,qr_token) VALUES ('Main Campus Recycling Station','Main campus','ECO-STATION-001');
INSERT INTO material_categories(name,points,min_weight,max_weight) VALUES
('Plastic Bottle (PET)',10,15,30),('Aluminum Can',15,10,15),
('Paper Drink Box',5,5,15),('Plastic Milk Tea / Juice Cup',5,8,15),
('Clean Cardboard / Small Food Box',5,20,60),
('Clean or Crumpled Paper (10 sheets)',5,40,50),
('Scantron / Answer Sheet (10 sheets, pending approval)',5,40,60),
('Non-recyclable waste',0,0,999);
INSERT INTO rewards(name,points_required,stock) VALUES ('Eraser',15,20),('Ballpen',25,20),('Notebook',60,10),('Yellow Pad',100,10);

-- Demo accounts. Password for all three: password
INSERT INTO users(name,email,student_id,password_hash,role,points_balance) VALUES
('Demo Student','student@demo.edu','DEMO-001','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi','student',50),
('Demo Personnel','personnel@demo.edu',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi','personnel',0),
('Demo Administrator','admin@demo.edu',NULL,'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi','admin',0);
