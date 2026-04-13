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

## Academic Information

- **Student:** Nurzhamal Bektassova
- **Institution:** MCAST
- **Unit:** API Development
- **Academic Year:** 2025–2026




