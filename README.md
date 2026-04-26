# lms-rest-api

RESTful LMS API for web, mobile, and third-party integrations.

## Description

A centralized RESTful API built in PHP for a Learning Management System (LMS).
This API acts as the communication layer between the existing PHP web application,
the Ionic mobile application, and any third-party systems that need to integrate
with the LMS.

## Technology Stack

- **Language:** PHP 8+
- **Database:** MySQL (SchoolManagement)
- **Connection:** PDO
- **Local Server:** MAMP (Apache port 8888, MySQL port 8889)

## Project Structure
lms-rest-api/
├── classes/              # PHP classes for each resource
│   ├── Database.php      # Handles PDO database connection
│   ├── User.php          # User database operations
│   ├── Course.php        # Course database operations
│   ├── Assignment.php    # Assignment database operations
│   ├── Submission.php    # Submission database operations
│   └── Grade.php         # Grade database operations
├── config/               # Database connection (not tracked by Git)
│   └── config.php        # Database credentials and PDO setup
├── endpoints/            # API endpoint files
│   ├── users.php         # User endpoints (GET, POST, PUT, DELETE)
│   ├── courses.php       # Course endpoints (GET, POST, PUT, DELETE)
│   ├── assignments.php   # Assignment endpoints (GET, POST, PUT, DELETE)
│   ├── submissions.php   # Submission endpoints (GET, POST, DELETE)
│   └── grades.php        # Grade endpoints (GET, POST, PATCH, DELETE)
├── postman-collections/  # Exported Postman test collections
├── .htaccess             # URL routing rules
├── index.php             # Entry point of the API
└── README.md             # Project documentation

## Database

- **Database name:** SchoolManagement
- **Tables:** users, courses, assignments, submissions, grades

## API Endpoints

| Resource | GET | POST | PUT | PATCH | DELETE |
|---       |---  |---   |---  |---    |---     |
| /users   | ✅   | ✅   | ✅  | ❌     | ✅     |
| /courses | ✅   | ✅   | ✅  | ❌     | ✅     |
| /assignments| ✅| ✅   | ✅  | ❌     | ✅     |
| /submissions| ✅| ✅   | ❌  | ❌     | ✅     |
| /grades     | ✅| ✅   | ❌  | ✅     | ✅     |

## Progress

- [x] Repository created
- [x] Folder structure set up
- [x] config.php created and protected via .gitignore
- [x] classes/Database.php
- [x] classes/User.php
- [x] classes/Course.php
- [x] classes/Assignment.php
- [x] classes/Submission.php
- [x] classes/Grade.php
- [x] index.php entry point
- [x] .htaccess routing rules
- [x] endpoints/users.php
- [x] endpoints/courses.php
- [x] endpoints/assignments.php
- [x] endpoints/submissions.php
- [x] endpoints/grades.php
- [ ] API tested and working locally
- [ ] PHP cURL consumer application
- [ ] Postman collections

Progress (Updated)
[x] Repository created

[x] Folder structure set up

[x] config.php created and protected via .gitignore

[x] classes/Database.php

[x] classes/User.php

[x] classes/Course.php

[x] classes/Assignment.php

[x] classes/Submission.php

[x] classes/Grade.php

[x] index.php entry point

[x] .htaccess routing rules

[x] endpoints/users.php

[x] endpoints/courses.php

[x] endpoints/assignments.php

[x] endpoints/submissions.php

[x] endpoints/grades.php

[x] API tested and working locally (GET, POST, PUT, DELETE verified via Postman)

[x] PHP cURL consumer application (Created test.php and verified data rendering)

[ ] Postman collections (To be exported)

[ ] Ionic mobile application integration


Was tested ALL 5 endpoints,and thye  are working perfectly! 
✅ /users      — returning data
✅ /courses    — returning data
✅ /assignments — returning data
✅ /submissions — returning data
✅ /grades     — returning data

Progress Update (April 26, 2026)
API & Database Integration
Fixed Integrity Constraints: Resolved SQLSTATE[23000] errors by correctly mapping unit_id and lecturer_id in the Assignments table.

Database Logic: Established a clear distinction between Courses (high-level subjects) and Units (specific modules), ensuring all foreign key relationships are valid.

Testing: Verified all core endpoints using Postman:

Users: CRUD operations successful.

Assignments: Linked to specific units and lecturers.

Grades: Implemented partial updates using the PATCH method for the mark field.

Postman Documentation
Unified Collection: Organized all individual requests into a single, structured collection named LMS_Final_Project.

Folder Hierarchy: Requests are logically grouped into folders: Users, Courses, Assignments, and Grades.

Portable Export: The final API collection is exported and available for testing.

Location: /postman-collections/LMS_Final_API.json

Postman API Collection
The project includes a ready-to-use API collection for testing.

File: /postman-collections/LMS_Final_API.json

How to use: Import this JSON file into your Postman to access all pre-configured requests (GET, POST, PUT, PATCH, DELETE) for Users, Courses, Assignments, and Grades.
Update: Log of Changes (April 26, 2026)
Backend API (PHP):

Fixed Authentication Endpoint: Successfully resolved a Fatal Error in auth.php related to database connection type mismatches.

Database Connection Refactoring: Bypassed the inconsistent Database.php class by implementing a direct PDO connection within the auth.php endpoint. This ensures stable communication with the MySQL server in the MAMP environment.

Configuration Fix: Corrected the database name to SchoolManagement and synchronized credentials (root/root).

Successful Integration Test: Verified via Postman that the login method now correctly validates users and returns a full JSON profile (User ID, Role, Name, Email, and Profile Photo path).

Current Status:

Login API: Fully functional (HTTP 200 OK).

Database: Connected and responding to queries.

Next step: Integration of this working API into the Ionic mobile application.

## Academic Information

- **Student:** Nurzhamal Bektassova
- **Institution:** MCAST
- **Unit:** API Development
- **Academic Year:** 2025–2026




