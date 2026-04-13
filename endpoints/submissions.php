<?php

/**
 * endpoints/submissions.php
 * 
 * Handles all API requests related to submissions.
 * Supports GET, POST and DELETE methods.
 * Uses the Submission class to interact with the database.
 */

// Create a new Submission instance using the database connection
$submission = new Submission($database->getConnection());

// Get the HTTP request method (GET, POST, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    /**
     * GET /api/submissions                    — returns all submissions
     * GET /api/submissions?student_id=        — filtered by student
     * GET /api/submissions?assignment_id=     — filtered by assignment
     * GET /api/submissions/{id}               — returns a single submission
     */
    case 'GET':
        if ($id) {
            // Get a single submission by ID
            $result = $submission->getById($id);
            if ($result) {
                http_response_code(200);
                echo json_encode($result);
            } else {
                http_response_code(404);
                echo json_encode([
                    'error'  => 'Submission not found',
                    'status' => 404
                ]);
            }
        } else {
            // Get all submissions, optionally filtered
            $student_id    = isset($_GET['student_id'])
                             ? (int)$_GET['student_id']
                             : null;
            $assignment_id = isset($_GET['assignment_id'])
                             ? (int)$_GET['assignment_id']
                             : null;
            $result = $submission->getAll($student_id, $assignment_id);
            http_response_code(200);
            echo json_encode($result);
        }
        break;

    /**
     * POST /api/submissions — creates a new submission
     * Required fields: assignment_id, student_id
     */
    case 'POST':
        // Read and decode the JSON request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (
            empty($data['assignment_id']) ||
            empty($data['student_id'])
        ) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Missing required fields: 
                             assignment_id, student_id',
                'status' => 400
            ]);
            break;
        }

        // Create the new submission and return its ID
        $new_id = $submission->create($data);
        http_response_code(201);
        echo json_encode([
            'message'       => 'Submission created successfully',
            'submission_id' => $new_id
        ]);
        break;

    /**
     * DELETE /api/submissions/{id} — deletes a submission by ID
     */
    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Submission ID is required',
                'status' => 400
            ]);
            break;
        }

        // Delete the submission
        $success = $submission->delete($id);
        if ($success) {
            http_response_code(200);
            echo json_encode([
                'message' => 'Submission deleted successfully'
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'error'  => 'Submission not found',
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