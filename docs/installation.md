

# Installation Guide

To get this API running locally, follow these steps:

### Prerequisites
* **Local Server:** MAMP, XAMPP, or WAMP (PHP 7.4 or higher recommended).
* **Database:** MySQL.
* **Tools:** Postman (for testing), MkDocs (for documentation).

### Setup Steps
1. **Clone the Repository:**
   Place the project folder in your server's root directory (e.g., `/htdocs/lms-rest-api/`).
2. **Database Import:**
   - Open phpMyAdmin.
   - Create a new database named `lms_db`.
   - Import the `LMS_Database_Final.sql` file provided in the repository.
3. **Configuration:**
   Check `/includes/config.php` and update the database credentials (username, password, port) to match your local setup.
4. **Verify:**
   Navigate to `http://localhost:8888/lms-rest-api/consume_api_test.php` to see if the API fetches data correctly.