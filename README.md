# EcoPoints Web Application

A PHP/MySQL starter implementation based on the EcoPoints project proposal.

## Requirements
- XAMPP (Apache + PHP + MySQL)
- PHP 8+
- MySQL/MariaDB

## Setup
1. Copy the `EcoPoints_Website` folder into `xampp/htdocs/`.
2. Start Apache and MySQL in XAMPP.
3. Open phpMyAdmin and import `database/ecopoints.sql`.
4. Open `config/database.php` and adjust credentials if needed.
5. Visit `http://localhost/EcoPoints_Website/`.

## Demo access
After importing the database, use:
- Student: `student@demo.edu` / `password`
- Personnel: `personnel@demo.edu` / `password`
- Administrator: `admin@demo.edu` / `password`

These are demonstration accounts only. Change passwords before any real deployment.

## Important prototype limitations
- QR station flow is represented by a station selection / session page. Real QR generation and camera scanning need to be connected.
- `api/sensor_reading.php` is a protected integration endpoint scaffold for the ESP32. It does not receive real sensor data unless the hardware is configured to call it with a valid device key.
- Weight thresholds and point values are initial proposal values and must be calibrated and approved by the university.
- This prototype is not production-ready. Configure HTTPS, email verification, CSRF protection, rate limits, device-key storage, backups, and privacy review before deployment.
