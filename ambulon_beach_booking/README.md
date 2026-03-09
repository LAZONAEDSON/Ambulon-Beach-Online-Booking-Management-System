Ambulon Beach Booking - Local Installation Guide

1) Prerequisites
- WAMP (Apache + PHP + MySQL) installed on Windows
- Place the project folder inside WAMP's `www` directory: Example: C:/wamp64/www/ambulon_beach_booking

2) Files
- Project root: ambulon_beach_booking
- Important directories: `admin/`, `assets/`, `inc/`, `sql/`

3) Create database
- Start WAMP and open phpMyAdmin (http://localhost/phpmyadmin)
- Import `sql/ambulon.sql` or run its SQL to create `ambulon_db` and tables.

4) Configure DB (if needed)
- Open `inc/db.php` and adjust `$host`, `$user`, `$pass` if your MySQL settings differ.

5) Sample admin user
- If no admin exists, visit `http://localhost/ambulon_beach_booking/admin/login.php` and the system will auto-create a default admin: username `admin`, password `admin123`. Change password after login by updating DB.

6) Run the app
- Open `http://localhost/ambulon_beach_booking/index.php` to view the landing page.
- Admin panel: `http://localhost/ambulon_beach_booking/admin/login.php`

7) Notes
- Images: place sample images in `assets/images/` (filenames from SQL: cottage1.jpg, room1.jpg, offer1.jpg) or upload via admin pages.
- Chart.js and other libraries are loaded via CDN.
- For production, secure admin authentication and validation.

Enjoy testing locally.
