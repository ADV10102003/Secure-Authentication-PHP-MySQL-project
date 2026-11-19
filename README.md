# Secure-Authentication-PHP-MySQL-project
PHP and MySQL-based secure authentication system featuring password hashing, session management, cookies, and OTP-based Multi-Factor Authentication (MFA).
This project is a web-based secure authentication system developed using PHP, MySQL, HTML, and CSS. It implements a multi-layer authentication process to improve user account security beyond traditional username and password login.

The system provides user registration, secure password hashing, login authentication, session management, cookie handling, and OTP-based Multi-Factor Authentication (MFA).

After successful password verification, users must complete a second authentication step by entering a six-digit One-Time Password (OTP). Once verified, they can access a protected dashboard. The system also uses PHP sessions, secure cookie settings, and prepared SQL statements to support secure user authentication and database operations.

Key Features

User registration and login.

Secure password hashing using PHP password functions.

MySQL database integration.

OTP-based Multi-Factor Authentication.

PHP session management.

Secure cookie configuration.

OTP expiration and attempt restrictions.

Protected user dashboard.

Secure logout functionality.

Technologies Used

PHP

MySQL

HTML5

CSS3

Apache Server

XAMPP

phpMyAdmin

Project Objective

The main objective is to demonstrate how multiple authentication mechanisms can work together to improve the security of a web application and protect user accounts from unauthorized access.

Note: This project currently uses a locally displayed OTP for demonstration purposes. Email-based OTP delivery is not configured.
