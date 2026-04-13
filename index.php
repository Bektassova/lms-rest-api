<?php

/**
 * index.php
 * 
 * Entry point of the LMS REST API.
 * Receives all incoming HTTP requests, loads the database
 * connection and routes the request to the correct endpoint.
 */

// Set the response type to JSON for all responses
header("Content-Type: application/json");

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Load the database connection from config
require_once __DIR__ . '/config/config.php';

// Load all classes
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/Courses.php';
require_once __DIR__ . '/classes/Assignment.php';
require_once __DIR__ . '/classes/Submission.php';
require_once __DIR__ . '/classes/Grade.php';

// Create the Database instance using the PDO connection
$database = new Database($db);

// Get the request URI and remove the base path
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_path   = '/lms-rest-api';
$route       = str_replace($base_path, '', $request_uri);
$route       = trim($route, '/');

// Split the route into parts
// Example: users/5 => ['users', '5']
$parts    = explode('/', $route);
$resource = $parts[0] ?? '';
$id       = isset($parts[1]) ? (int)$parts[1] : null;

// Route to the correct endpoint file
switch ($resource) {
    case 'users':
        require_once __DIR__ . '/endpoints/users.php';
        break;

    case 'courses':
        require_once __DIR__ . '/endpoints/courses.php';
        break;

    case 'assignments':
        require_once __DIR__ . '/endpoints/assignments.php';
        break;

    case 'submissions':
        require_once __DIR__ . '/endpoints/submissions.php';
        break;

    case 'grades':
        require_once __DIR__ . '/endpoints/grades.php';
        break;
    default:
        http_response_code(404);
        echo json_encode([
            'error'  => 'Endpoint not found',
            'status' => 404
        ]);
        break;
}

?>