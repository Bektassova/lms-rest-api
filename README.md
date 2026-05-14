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

 — May 1st, 2026 Updating:
Recent Progress
* Frontend & Backend Integration
Authentication Flow: Successfully linked the Ionic frontend with the PHP backend. The application now performs real-time user verification against the MySQL database.

Dynamic Session Handling: Implemented AuthService to manage user sessions. Upon successful login, user data (ID, Name, Email, Role) is stored locally and persists across the application.

Reactive UI Updates:

Updated Dashboard to display a personalized greeting (e.g., "Welcome, Maxim!") using data fetched from the database.

Enhanced Profile Page to reflect real user information instead of static placeholders.

Logout Logic: Integrated a secure logout function that clears the local session and redirects the user back to the authentication screen.

* Technical Improvements
Bug Fixes: Resolved issues with case-sensitivity in user roles (Student vs student) by implementing .toLowerCase() checks.

API Communication: Configured HttpClient to handle asynchronous requests to the PHP API, including proper error handling for network or database failures.

Navigation Guarding: Implemented navigateRoot to ensure proper page transitions after successful authentication.



Update: May 2, 2026 — Structural Architecture & API Success
This was a challenging day of debugging. I have finally stabilized the project structure and fixed the data flow after multiple attempts to reorganize the files.

* Structure & Path Resolution (The Big Fix)
Restoring Project Integrity: I moved get_timetable.php back to its rightful place inside the project folder (lms-rest-api/endpoints/). I realized that moving it to the root htdocs caused more harm than good with broken paths.

* Fixing File Connections: I successfully resolved the require_once issues by using __DIR__. Now the API correctly finds the config.php and database.php files regardless of where the server is running. No more "File not found" errors!

✅ Database & Data Logic
Smart Query Implementation: I rewrote the SQL logic to be more inclusive. The app now displays both my specific student schedule (ID 27/17) AND general university classes (where user_id is NULL).

Data Cleanup: I manually audited the timetable table in phpMyAdmin, deleting messy duplicate records and fixing those "00:00:00" timestamps that were breaking the UI.

✅ Ionic Integration & Bug Squashing
Compiler Victory: I fought through the "Application bundle generation failed" errors. By fixing the TypeScript strict mode issues in assignments.page.ts and dashboard.page.ts using proper type casting, I finally got the app to serve.

End-to-End Success: The connection is now solid: MySQL ↔ PHP (in lms-rest-api) ↔ Ionic Frontend.

* Current Status:
Everything is back in its correct folder. The API is secure, the paths are fixed, and the timetable is displaying real, clean data from the database.




## Update 7 May 2026: Step 5: API Consumption via cURL (MCAST Task 2 - Part 3)
To satisfy the requirements of Part 3, I developed a standalone PHP application that acts as a client.

- **File:** `consume_api_test.php`
- **Purpose:** This script uses the `curl_init()`, `curl_setopt()`, and `curl_exec()` functions to fetch data from the `get_timetable.php` endpoint.
- **Functionality:** It converts the JSON response back into a PHP array and displays the student's timetable in a clean, human-readable HTML table. This proves that the API can be consumed by any external PHP system, not just the mobile app.

## Step 6: Advanced API Testing (Postman)
Following the AA4 requirement, the Postman collections were updated:
- **Multiple Parameters:** Created separate requests for `student_id=27` (Max) and `student_id=17` (Alim).
- **Data Integrity:** Verified that the API correctly filters unique schedules (e.g., Alim has an extra English lesson at 08:00 AM while Max starts at 09:00 AM).
- **Exports:** The final collection is exported as a JSON file and located in the `/postman_collections` folder.

##  Step 7: Professional Documentation (MkDocs)
To comply with Task 3 (Part 2), I implemented a dedicated documentation website using **MkDocs**.

- **Tooling:** Built with Python and MkDocs.
- **Content:** The site includes detailed technical specifications for every endpoint, including expected parameters, request methods, and example JSON responses.
- **Navigation:** Includes "Introduction", "Installation Guide", and "API Endpoints" sections for future developers.

### Update 8 May 2026: Technical Challenges & Troubleshooting 
During the implementation of the MkDocs site, I encountered and resolved several architectural challenges:

* **Project Structure Refactoring:** Initially, following the general instructions, the documentation was nested deep within sub-directories (`DocumentationWebsite/docs/`). This caused a conflict where the terminal could not locate the `mkdocs.yml` configuration file from the project root.
* **Resolution:** I refactored the file structure by moving the `mkdocs.yml` and the `/docs` folder directly to the root directory (`/lms-rest-api`). This ensured that the documentation is part of the core repository structure and easily accessible for build commands.
* **Environment Configuration:** Encountered an issue where the 'Material' theme was not recognized due to Python environment path differences on macOS.
* **Resolution:** Successfully reconfigured the environment using `python3 -m pip install` and verified the build using the `readthedocs` stable theme to ensure 100% compatibility and professional visual output.
* **Final Result:** A fully functional, responsive documentation website that mirrors the API logic found in my Postman collections and PHP endpoints.

## Update 14 May 2026– Consuming an API through cURL (AA2)

The file `consume_api_test.php` demonstrates all four HTTP request types using cURL:

| Method     | Endpoint                          | Description |
|--------    |----------|-------------|
| **GET**    | `get_timetable.php?student_id=27` | Retrieves a student’s timetable and displays it as an HTML table |
| **POST**   | `users.php`                       | Creates a new user (JSON payload) |
| **PUT**    | `courses.php?id=10`               | Requests to update the course name (e.g., from `English` to `English Advanced`)   |
| **DELETE** | `assignments.php?id=5`            | Requests to delete an assignment |

Each request:
- Uses proper cURL functions (`curl_init()`, `curl_setopt()`, `curl_exec()`);
- Sends the required HTTP headers (`Content-Type: application/json`);
- Outputs the HTTP response code (all returned `200 OK`);
- Presents the result in a readable format (table for GET, formatted JSON for the others).

> **Note about the PUT request:** The server responded with `200 OK`, meaning the request was accepted. Whether the database is actually updated depends on the implementation of the `courses.php` endpoint. The example proves that the cURL consumer is able to send a correctly formed PUT request.

The script can be accessed at:  
`http://localhost:8888/lms-rest-api/consume_api_test.php`




📱 Mobile Integration (Ionic Framework)
The documentation and API endpoints in this repository are designed to support the SchoolMSApp mobile application.

Frontend Repository: https://github.com/Bektassova/SchoolMSApp

Integration Status: Fully connected via data.service.ts.

🔄 Recent Updates & Bug Fixes (May 2026)
To ensure seamless integration between the Ionic Mobile App and this PHP API, the following technical updates were implemented in the frontend:

TypeScript Optimization: Resolved compilation errors (TS2339) in assignments.page.ts and dashboard.page.ts by implementing proper type casting (as any[]) to handle dynamic API responses.

Data Integrity: Refactored data.service.ts to align with the new JSON structure returned by the PHP backend, ensuring consistent data mapping.

Build Stability: Fixed priority type mismatches in the announcements module to ensure a successful production build for Android/iOS.



## Academic Information

- **Student:** Nurzhamal Bektassova
- **Institution:** MCAST
- **Unit:** API Development
- **Academic Year:** 2025–2026




