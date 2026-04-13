<?php

/**
 * endpoints/grades.php
 * 
 * Handles all API requests related to grades.
 * Supports GET, POST, PATCH and DELETE methods.
 * Uses the Grade class to interact with the database.
 */

// Create a new Grade instance using the database connection
$grade = new Grade($database->getConnection());

// Get the HTTP request method (GET, POST, PATCH, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    /**
     * GET /api/grades                  — returns all grades
     * GET /api/grades?student_id=      — filtered by student
     * GET /api/grades?lecturer_id=     — filtered by lecturer
     * GET /api/grades/{id}             — returns a single grade
     */
    case 'GET':
        if ($id) {
            // Get a single grade by ID
            $result = $grade->getById($id);
            if ($result) {
                http_response_code(200);
                echo json_encode($result);
            } else {
                http_response_code(404);
                echo json_encode([
                    'error'  => 'Grade not found',
                    'status' => 404
                ]);
            }
        } else {
            // Get all grades, optionally filtered
            $student_id  = isset($_GET['student_id'])
                           ? (int)$_GET['student_id']
                           : null;
            $lecturer_id = isset($_GET['lecturer_id'])
                           ? (int)$_GET['lecturer_id']
                           : null;
            $result = $grade->getAll($student_id, $lecturer_id);
            http_response_code(200);
            echo json_encode($result);
        }
        break;

    /**
     * POST /api/grades — creates a new grade
     * Required fields: submission_id, lecturer_id, mark
     * Optional fields: feedback
     */
    case 'POST':
        // Read and decode the JSON request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (
            empty($data['submission_id']) ||
            empty($data['lecturer_id'])   ||
            !isset($data['mark'])
        ) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Missing required fields: 
                             submission_id, lecturer_id, mark',
                'status' => 400
            ]);
            break;
        }

        // Create the new grade and return its ID
        $new_id = $grade->create($data);
        http_response_code(201);
        echo json_encode([
            'message'  => 'Grade created successfully',
            'grade_id' => $new_id
        ]);
        break;

    /**
     * PATCH /api/grades/{id} — partially updates an existing grade
     * Required fields: mark
     * Optional fields: feedback
     */
    case 'PATCH':
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Grade ID is required',
                'status' => 400
            ]);
            break;
        }

        // Read and decode the JSON request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (!isset($data['mark'])) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Missing required field: mark',
                'status' => 400
            ]);
            break;
        }

        // Update the grade
        $success = $grade->update($id, $data);
        if ($success) {
            http_response_code(200);
            echo json_encode([
                'message' => 'Grade updated successfully'
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'error'  => 'Grade not found',
                'status' => 404
            ]);
        }
        break;

    /**
     * DELETE /api/grades/{id} — deletes a grade by ID
     */
    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Grade ID is required',
                'status' => 400
            ]);
            break;
        }

        // Delete the grade
        $success = $grade->delete($id);
        if ($success) {
            http_response_code(200);
            echo json_encode([
                'message' => 'Grade deleted successfully'
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'error'  => 'Grade not found',
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