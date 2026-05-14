# 👤 User Profile Management

This endpoint is responsible for fetching detailed information about a specific user. It is used in the Ionic application to populate the **Profile Page** after a successful login.

## 1. Get User Details
Retrieves all personal information for a student based on their unique ID.

* **Endpoint:** `/endpoints/get_user.php` 
* **Method:** `GET`
* **Query Parameter:** `user_id` (Integer)

---

## 2. Integration with Mobile App (Ionic)
When the user "Max" (ID: 27) logs into the system, the mobile app sends a request to this endpoint to display:
- Full Name
- Email Address
- Student ID / Registration Number
- Profile Picture URL (if applicable)

## 3. Postman Validation
We verified this by testing with Max's ID:

* **Request:** `GET .../get_user.php?user_id=27`
* **Expected Result:** A JSON object containing Max's specific profile data.

---

## 4. Response Schema
The API returns a single JSON object (not an array), which is easier for the app to parse for a profile view:

```json
{
    "user_id": 27,
    "full_name": "Max Power",
    "email": "max.power@student.mcast.edu.mt",
    "role": "student",
    "created_at": "2024-01-15"
}