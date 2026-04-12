<?php

/**
 * endpoints/assignments.php
 * 
 * Handles all API requests related to assignments.
 * Supports GET, POST, PUT and DELETE methods.
 * Uses the Assignment class to interact with the database.
 */

// Create a new Assignment instance using the database connection
$assignment = new Assignment($database->getConnection());

// Get the HTTP request method (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    /**
     * GET /api/assignments             — returns all assignments
     * GET /api/assignments?unit_id=    — filtered by unit
     * GET /api/assignments/{id}        — returns a single assignment
     */
    case 'GET':
        if ($id) {
            // Get a single assignment by ID
            $result = $assignment->getById($id);
            if ($result) {
                http_response_code(200);
                echo json_encode($result);
            } else {
                http_response_code(404);
                echo json_encode([
                    'error'  => 'Assignment not found',
                    'status' => 404
                ]);
            }
        } else {
            // Get all assignments, optionally filtered by unit_id
            $unit_id = isset($_GET['unit_id']) 
                       ? (int)$_GET['unit_id'] 
                       : null;
            $result  = $assignment->getAll($unit_id);
            http_response_code(200);
            echo json_encode($result);
        }
        break;

    /**
     * POST /api/assignments — creates a new assignment
     * Required fields: unit_id, lecturer_id, title, 
     *                  description, due_date
     */
    case 'POST':
        // Read and decode the JSON request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (
            empty($data['unit_id'])     ||
            empty($data['lecturer_id']) ||
            empty($data['title'])       ||
            empty($data['description']) ||
            empty($data['due_date'])
        ) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Missing required fields: unit_id, 
                             lecturer_id, title, description, due_date',
                'status' => 400
            ]);
            break;
        }

        // Create the new assignment and return its ID
        $new_id = $assignment->create($data);
        http_response_code(201);
        echo json_encode([
            'message'       => 'Assignment created successfully',
            'assignment_id' => $new_id
        ]);
        break;

    /**
     * PUT /api/assignments/{id} — fully updates an existing assignment
     * Required fields: title, description, due_date
     */
    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Assignment ID is required',
                'status' => 400
            ]);
            break;
        }

        // Read and decode the JSON request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (
            empty($data['title'])       ||
            empty($data['description']) ||
            empty($data['due_date'])
        ) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Missing required fields: 
                             title, description, due_date',
                'status' => 400
            ]);
            break;
        }

        // Update the assignment
        $success = $assignment->update($id, $data);
        if ($success) {
            http_response_code(200);
            echo json_encode([
                'message' => 'Assignment updated successfully'
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'error'  => 'Assignment not found',
                'status' => 404
            ]);
        }
        break;

    /**
     * DELETE /api/assignments/{id} — deletes an assignment by ID
     */
    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Assignment ID is required',
                'status' => 400
            ]);
            break;
        }

        // Delete the assignment
        $success = $assignment->delete($id);
        if ($success) {
            http_response_code(200);
            echo json_encode([
                'message' => 'Assignment deleted successfully'
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'error'  => 'Assignment not found',
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