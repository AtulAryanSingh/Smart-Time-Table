-- Smart Time Table DB
-- Database: university_timetable

DROP TABLE IF EXISTS timetable_entries;
DROP TABLE IF EXISTS timeslots;
DROP TABLE IF EXISTS rooms;
DROP TABLE IF EXISTS teachers;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS courses;

CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  year INT NOT NULL,
  semester INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','student') NOT NULL DEFAULT 'student',
  course_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_users_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL
);

CREATE TABLE teachers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rooms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60) NOT NULL,
  capacity INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE timeslots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  day_of_week ENUM('Mon','Tue','Wed','Thu','Fri','Sat') NOT NULL,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE timetable_entries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT NOT NULL,
  room_id INT NOT NULL,
  teacher_id INT NOT NULL,
  subject VARCHAR(120) NOT NULL,
  timeslot_id INT NOT NULL,
  expected_students INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_tt_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
  CONSTRAINT fk_tt_room FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE RESTRICT,
  CONSTRAINT fk_tt_teacher FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE RESTRICT,
  CONSTRAINT fk_tt_timeslot FOREIGN KEY (timeslot_id) REFERENCES timeslots(id) ON DELETE CASCADE,
  UNIQUE KEY uq_room_timeslot (room_id, timeslot_id),
  UNIQUE KEY uq_teacher_timeslot (teacher_id, timeslot_id)
);

-- Seed data
INSERT INTO courses (name, year, semester) VALUES
  ('BSc Computer Science', 1, 1),
  ('BSc Computer Science', 1, 2),
  ('BSc Computer Science', 2, 1);

-- Passwords are bcrypt hashes.
-- Admin@123
-- Student@123
INSERT INTO users (name, email, password_hash, role, course_id) VALUES
  ('Admin User', 'admin@uni.com', '$2y$10$gEwWbAphXW2n0WZVfD7hQuyFLk8m6k7o8j8bGmYJ3vQY2R3x5gkQG', 'admin', NULL),
  ('Student User', 'student@uni.com', '$2y$10$2k6T4X3lQYcM2qX/6cPq.eN5xVY0gGz2Xnqk8v4dCqv7oQxWm9x4K', 'student', 1);

INSERT INTO teachers (name, email) VALUES
  ('Dr. Smith', 'smith@uni.com'),
  ('Prof. Johnson', 'johnson@uni.com');

INSERT INTO rooms (name, capacity) VALUES
  ('A-101', 40),
  ('A-102', 60),
  ('Lab-1', 30);

INSERT INTO timeslots (day_of_week, start_time, end_time) VALUES
  ('Mon', '09:00:00', '10:00:00'),
  ('Mon', '10:00:00', '11:00:00'),
  ('Tue', '09:00:00', '10:00:00');

INSERT INTO timetable_entries (course_id, room_id, teacher_id, subject, timeslot_id, expected_students) VALUES
  (1, 1, 1, 'Web Programming', 1, 35),
  (1, 2, 2, 'Mathematics', 2, 45);
