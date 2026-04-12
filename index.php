<?php

/**
 * index.php
 * 
 * Entry point of the LMS REST API.
 * This file receives all incoming HTTP requests,
 * loads the database connection and the required class,
 * and routes the request to the correct endpoint file.
 */

// Set the response type to JSON for all responses
header("Content-Type: application/json");

// Allow cross-origin requests (needed for mobile and third-party access)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Load the database connection from config
require_once 'config/config.php';

// Load all classes
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'classes/Course.php';
require_once 'classes/Assignment.php';
require_once 'classes/Submission.php';
require_once 'classes/Grade.php';

// Create the Database instance using the PDO connection from config.php
$database = new Database($db);

// Get the request URI and remove the base path
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_path   = '/lms-rest-api';
$route       = str_replace($base_path, '', $request_uri);
$route       = trim($route, '/');

// Split the route into parts
// Example: /api/users/5 => ['api', 'users', '5']
$parts = explode('/', $route);

// The resource is the second part after 'api'
// Example: api/users => $resource = 'users'
$resource = $parts[1] ?? '';

// The ID is the third part if it exists
// Example: api/users/5 => $id = 5
$id = isset($parts[2]) ? (int)$parts[2] : null;

// Route to the correct endpoint file based on the resource name
switch ($resource) {
    case 'users':
        require_once 'endpoints/users.php';
        break;

    case 'courses':
        require_once 'endpoints/courses.php';
        break;

    case 'assignments':
        require_once 'endpoints/assignments.php';
        break;

    case 'submissions':
        require_once 'endpoints/submissions.php';
        break;

    case 'grades':
        require_once 'endpoints/grades.php';
        break;

    default:
        // Return 404 if the resource is not recognised
        http_response_code(404);
        echo json_encode([
            'error'   => 'Endpoint not found',
            'status'  => 404
        ]);
        break;
}

?>