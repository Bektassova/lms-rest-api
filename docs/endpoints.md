# API Endpoints

## Get Timetable 📅
Retrieves the weekly schedule for a specific student.

**URL:** `/endpoints/get_timetable.php`  
**Method:** `GET`  
**Auth Required:** No (Development mode)

### URL Parameters
| Parameter | Type | Description |
| :--- | :--- | :--- |
| `student_id` | `Integer` | **Required**. The unique ID of the student (e.g., 27 for Max, 17 for Alim). |

### Success Response
**Code:** 200 OK  
**Content:**
```json
[
  {
    "subject_name": "Programming I",
    "class_day": "Monday",
    "start_time": "09:00:00",
    "end_time": "10:30:00",
    "room_number": "Lab 102"
  }
]s