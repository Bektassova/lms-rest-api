<?php

/**
 * endpoints/courses.php
 * 
 * Handles all API requests related to courses.
 * Supports GET, POST, PUT and DELETE methods.
 * Uses the Course class to interact with the database.
 */

// Create a new Course instance using the database connection
$course = new Course($database->getConnection());

// Get the HTTP request method (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    /**
     * GET /api/courses      — returns all courses
     * GET /api/courses/{id} — returns a single course by ID
     */
    case 'GET':
        if ($id) {
            // Get a single course by ID
            $result = $course->getById($id);
            if ($result) {
                http_response_code(200);
                echo json_encode($result);
            } else {
                http_response_code(404);
                echo json_encode([
                    'error'  => 'Course not found',
                    'status' => 404
                ]);
            }
        } else {
            // Get all courses
            $result = $course->getAll();
            http_response_code(200);
            echo json_encode($result);
        }
        break;

    /**
     * POST /api/courses — creates a new course
     * Required fields: course_name, course_description
     */
    case 'POST':
        // Read and decode the JSON request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (
            empty($data['course_name']) ||
            empty($data['course_description'])
        ) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Missing required fields: 
                             course_name, course_description',
                'status' => 400
            ]);
            break;
        }

        // Create the new course and return its ID
        $new_id = $course->create($data);
        http_response_code(201);
        echo json_encode([
            'message'   => 'Course created successfully',
            'course_id' => $new_id
        ]);
        break;

    /**
     * PUT /api/courses/{id} — fully updates an existing course
     * Required fields: course_name, course_description
     */
    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Course ID is required',
                'status' => 400
            ]);
            break;
        }

        // Read and decode the JSON request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (
            empty($data['course_name']) ||
            empty($data['course_description'])
        ) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Missing required fields: 
                             course_name, course_description',
                'status' => 400
            ]);
            break;
        }

        // Update the course
        $success = $course->update($id, $data);
        if ($success) {
            http_response_code(200);
            echo json_encode([
                'message' => 'Course updated successfully'
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'error'  => 'Course not found',
                'status' => 404
            ]);
        }
        break;

    /**
     * DELETE /api/courses/{id} — deletes a course by ID
     */
    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Course ID is required',
                'status' => 400
            ]);
            break;
        }

        // Delete the course
        $success = $course->delete($id);
        if ($success) {
            http_response_code(200);
            echo json_encode([
                'message' => 'Course deleted successfully'
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'error'  => 'Course not found',
                'status' => 404
            ]);
        }
        break;

    /**
     * Any other HTTP method is not allowed
     */
    default:
        http_response_code(405);
        echo json_encode([
            'error'  => 'Method not allowed',
            'status' => 405
        ]);
        break;
}

?>