# Smart Time Table (PHP + MySQL)

A **Smart University Timetable** full‑stack web project (Frontend + Backend) built for a university Web Programming exam.

- Backend: **PHP 8 + MySQL/MariaDB** (PDO, Sessions)
- Frontend: **HTML + Bootstrap + Vanilla JS (fetch)**
- APIs: JSON endpoints under `public/api/*`

## Features

### Auth
- Register / Login / Logout
- Password hashing (`password_hash`, `password_verify`)

### Admin panel
- Manage (CRUD): Courses, Rooms, Teachers, Timeslots
- Create Timetable entries with validations

### Student view
- View timetable by course (read-only)

### Smart rules (realistic)
- **Room conflict** prevented (same room + same timeslot)
- **Teacher conflict** prevented (same teacher + same timeslot)
- If a room conflict occurs, API returns **suggested available rooms** for that timeslot

---

## Run on macOS using XAMPP

### 1) Install / start XAMPP
- Start **Apache** and **MySQL** from the XAMPP control panel.

### 2) Put project in htdocs
Copy this repo folder into your XAMPP `htdocs` directory.

Typical path:
- `/Applications/XAMPP/htdocs/Smart-Time-Table`

### 3) Create DB + import SQL
1. Open phpMyAdmin:
   - `http://localhost/phpmyadmin`
2. Create database:
   - `university_timetable`
3. Import:
   - `database/database.sql`

### 4) Configure DB credentials
Edit:
- `app/config.php`

Defaults are for XAMPP:
- host: `127.0.0.1`
- user: `root`
- password: *(blank)*
- db: `university_timetable`

### 5) Open the app
- `http://localhost/Smart-Time-Table/public/`

---

## Demo accounts (seeded)

- **Admin**: `admin@uni.com` / `Admin@123`
- **Student**: `student@uni.com` / `Student@123`

---

## Exam demo script (quick)
1. Login as **Admin**.
2. Show CRUD (add room/teacher).
3. Create a timetable entry.
4. Try to create a second entry with the **same room + timeslot** → app blocks it and shows suggestions.
5. Login as **Student** and show timetable view.

