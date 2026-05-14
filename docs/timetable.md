# 📅 Timetable Management

This section of the API handles the academic schedule for students. It is designed to deliver time-specific data filtered by user identity.

## 1. Get Student Timetable
This is the primary endpoint used by the Ionic Mobile Application to display the weekly schedule.

* **Endpoint:** `/endpoints/get_timetable.php`
* **Method:** `GET`
* **Query Parameter:** `student_id` (Integer)

---

## 2. Business Logic & Filtering
Our API implements a dual-filtering logic:
1.  **Common Lessons:** Returns rows where `user_id` is `NULL` (visible to all students).
2.  **Specific Lessons:** Returns rows matching the provided `student_id`.

## 3. Postman Test Cases (Validation)
To ensure the API works correctly, we tested two scenarios in Postman:

### Scenario A: Standard Student (ID: 27 - Max)
* **Request:** `GET .../get_timetable.php?student_id=27`
* **Expected Result:** Returns standard subjects like "Programming I" and "Mathematics".

### Scenario B: Student with Extra Classes (ID: 17 - Alim)
* **Request:** `GET .../get_timetable.php?student_id=17`
* **Expected Result:** Returns all standard subjects **plus** the "Extra English" lesson at 08:00 AM.

---

## 4. Response Schema
The API returns a JSON array of objects:

```json
[
  {
    "subject_name": "Programming I",
    "class_day": "Monday",
    "start_time": "09:00:00",
    "end_time": "10:30:00",
    "room_number": "Lab 102",
    "class_type": "Lecture"
  }
]