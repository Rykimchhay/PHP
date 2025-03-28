CREATE TABLE departments (
    department_id INT PRIMARY KEY AUTO_INCREMENT,
    department_name VARCHAR(100) NOT NULL
);

CREATE TABLE faculty (
    faculty_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES departments(department_id) ON DELETE SET NULL
);

CREATE TABLE students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE courses (
    course_id INT PRIMARY KEY AUTO_INCREMENT,
    course_code VARCHAR(20) UNIQUE NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    faculty_id INT,
    department_id INT,
    FOREIGN KEY (faculty_id) REFERENCES faculty(faculty_id) ON DELETE SET NULL,
    FOREIGN KEY (department_id) REFERENCES departments(department_id) ON DELETE SET NULL
);

CREATE TABLE enrollments (
    enrollment_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    course_id INT,
    enrollment_date DATE NOT NULL,
    grade DECIMAL(4,2),
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE
);

INSERT INTO departments (department_name) VALUES 
('Computer Science'),
('Mathematics'),
('Physics');

INSERT INTO faculty (first_name, last_name, email, department_id) VALUES 
('Kimchhay', 'Ry', 'Rykimchhay@gmail.com', 1),
('Kimlang', 'Ly', 'Kimlang@gmail.com', 2);

INSERT INTO students (first_name, last_name, date_of_birth, email) VALUES 
('Ammara', 'Ry', '2001-06-15', 'Ammara@gmail.com'),
('Gechoung', 'Sor', '2002-03-10', 'Gech@gmail.com'),
('Sophea', 'Chan', '2003-07-25', 'Sophea@gmail.com'), -- Not enrolled
('Dara', 'Kong', '2000-12-05', 'Dara@gmail.com'); -- Not enrolled

INSERT INTO courses (course_code, course_name, faculty_id, department_id) VALUES 
('CS101', 'Introduction to Programming', 1, 1),
('MATH201', 'Calculus II', 2, 2);

INSERT INTO enrollments (student_id, course_id, enrollment_date, grade) VALUES 
(1, 1, '2024-01-10', 3.5),
(2, 1, '2024-01-15', 3.8),
(1, 2, '2024-01-20', 3.2);

-- Queries

-- 1. Retrieve all students who enrolled in a specific course
SELECT students.student_id, students.first_name, students.last_name 
FROM students
JOIN enrollments ON students.student_id = enrollments.student_id
WHERE enrollments.course_id = (SELECT course_id FROM courses WHERE course_code = 'CS101');

-- 2. Find all faculty members in a particular department
SELECT faculty_id, first_name, last_name 
FROM faculty 
WHERE department_id = (SELECT department_id FROM departments WHERE department_name = 'Computer Science');

-- 3. List all courses a particular student is enrolled in
SELECT courses.course_code, courses.course_name 
FROM courses
JOIN enrollments ON courses.course_id = enrollments.course_id
WHERE enrollments.student_id = (SELECT student_id FROM students WHERE email = 'Ammara@gmail.com');

-- 4. Retrieve students who have not enrolled in any course
SELECT * FROM students 
WHERE student_id NOT IN (SELECT DISTINCT student_id FROM enrollments);

-- 5. Find the average grade of students in a specific course
SELECT AVG(grade) AS average_grade
FROM enrollments
WHERE course_id = (SELECT course_id FROM courses WHERE course_code = 'CS101');