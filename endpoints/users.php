<?php

/**
 * endpoints/users.php
 * 
 * Handles all API requests related to users.
 * Supports GET, POST, PUT and DELETE methods.
 * Uses the User class to interact with the database.
 */

// Create a new User instance using the database connection
$user = new User($database->getConnection());

// Get the HTTP request method (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    /**
     * GET /api/users        — returns all users
     * GET /api/users?role=  — returns users filtered by role
     * GET /api/users/{id}   — returns a single user by ID
     */
    case 'GET':
        if ($id) {
            // Get a single user by ID
            $result = $user->getById($id);
            if ($result) {
                http_response_code(200);
                echo json_encode($result);
            } else {
                http_response_code(404);
                echo json_encode([
                    'error'  => 'User not found',
                    'status' => 404
                ]);
            }
        } else {
            // Get all users, optionally filtered by role
            $role   = $_GET['role'] ?? null;
            $result = $user->getAll($role);
            http_response_code(200);
            echo json_encode($result);
        }
        break;

    /**
     * POST /api/users — creates a new user
     * Required fields: username, password, role, name, surname, email
     */
    case 'POST':
        // Read and decode the JSON request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (
            empty($data['username']) ||
            empty($data['password']) ||
            empty($data['role'])     ||
            empty($data['name'])     ||
            empty($data['surname'])  ||
            empty($data['email'])
        ) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Missing required fields: username, 
                             password, role, name, surname, email',
                'status' => 400
            ]);
            break;
        }

        // Create the new user and return its ID
        $new_id = $user->create($data);
        http_response_code(201);
        echo json_encode([
            'message' => 'User created successfully',
            'user_id' => $new_id
        ]);
        break;

    /**
     * PUT /api/users/{id} — fully updates an existing user
     * Required fields: name, surname, email, role
     */
    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'User ID is required',
                'status' => 400
            ]);
            break;
        }

        // Read and decode the JSON request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (
            empty($data['name'])    ||
            empty($data['surname']) ||
            empty($data['email'])   ||
            empty($data['role'])
        ) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'Missing required fields: 
                             name, surname, email, role',
                'status' => 400
            ]);
            break;
        }

        // Update the user
        $success = $user->update($id, $data);
        if ($success) {
            http_response_code(200);
            echo json_encode([
                'message' => 'User updated successfully'
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'error'  => 'User not found',
                'status' => 404
            ]);
        }
        break;

    /**
     * DELETE /api/users/{id} — deletes a user by ID
     */
    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'error'  => 'User ID is required',
                'status' => 400
            ]);
            break;
        }

        // Delete the user
        $success = $user->delete($id);
        if ($success) {
            http_response_code(200);
            echo json_encode([
                'message' => 'User deleted successfully'
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'error'  => 'User not found',
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