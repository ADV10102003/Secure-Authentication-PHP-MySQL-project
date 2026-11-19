SECURE AUTHENTICATION PROJECT
PHP + MySQL + Sessions + Cookies + MFA

REQUIREMENTS
- XAMPP for Windows with Apache, MySQL, and PHP 8+
- PHP PDO MySQL extension enabled (included/enabled in standard XAMPP)

INSTALLATION
1. Download and extract secure_auth_project.zip.
2. Inside the ZIP is a folder named secure-auth. Copy that entire folder to:
   C:\xampp\htdocs\secure-auth\
   Make sure the files are directly inside that folder, e.g.:
   C:\xampp\htdocs\secure-auth\login.php
3. Open XAMPP Control Panel and start Apache and MySQL.
4. Open http://localhost/phpmyadmin
5. Select the SQL tab. Open schema.sql from the project, copy all its SQL, paste it into the SQL tab, and click Go.
6. Open config.php and check the database values. Default XAMPP is:
   DB_HOST = 127.0.0.1
   DB_NAME = secure_auth
   DB_USER = root
   DB_PASS = ''
   If your MySQL root account has a password, set DB_PASS accordingly.
7. Open this URL:
   http://localhost/secure-auth/

HOW TO TEST
1. Click Create an account.
2. Register a username, valid email, and password of at least 10 characters.
3. Return to Sign in and enter the username/email and password.
4. The MFA page shows a six-digit OTP because DEMO_SHOW_OTP is true. This is intended only for local classroom demonstration without SMTP setup.
5. Enter that code within 5 minutes.
6. The dashboard should open only after the password and OTP both succeed.
7. Click Log out. Opening dashboard.php again should redirect to login.

IMPORTANT MFA NOTE
By default, DEMO_SHOW_OTP=true makes the local demo usable without email setup by displaying the OTP on the verification page. This is NOT safe for a deployed application. Do not expose this app to the internet in demo mode. For real email OTP, configure authenticated SMTP using a mail library, set DEMO_SHOW_OTP=false, and verify mail delivery.

SECURITY FEATURES DEMONSTRATED
- password_hash() and password_verify()
- PDO prepared statements
- Session cookies with HttpOnly and SameSite=Lax; Secure flag when HTTPS is detected
- Session ID regeneration during authentication
- CSRF tokens on POST forms
- OTP hash stored in the database, 5-minute expiry, one-time use, five-attempt limit
- Basic session-based login throttling
- Dashboard access control and logout/session invalidation

TROUBLESHOOTING
- “Database connection failed”: make sure MySQL is started and schema.sql ran successfully; check DB_PASS in config.php.
- “Not Found”: check the folder is C:\xampp\htdocs\secure-auth and the URL is http://localhost/secure-auth/.
- Apache port error: another app may be using port 80; resolve the port conflict in XAMPP.
- Blank page/PHP error: check C:\xampp\php\logs\php_error_log or Apache logs in XAMPP.

This is an academic local demonstration, not a production-ready authentication service. Production use needs HTTPS, robust shared rate limits, monitoring, secure account recovery, SMTP configuration, and stronger MFA such as TOTP or WebAuthn/passkeys.
