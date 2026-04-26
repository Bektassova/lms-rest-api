<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

// 1. Manually set MAMP credentials (to avoid the "array" error)
$host = 'localhost';
$db_name = 'SchoolManagement'; 
$username = 'root';
$password = 'root';

try {
    // 2. Create the connection directly using PDO
    $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";
    $db = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // 3. Include only the User class
    require_once __DIR__ . '/../classes/User.php';
    $user = new User($db);

    // 4. Handle Login
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['username']) && isset($data['password'])) {
        $userData = $user->login($data['username'], $data['password']);

        if ($userData) {
            echo json_encode([
                "status" => "success",
                "message" => "Login successful",
                "user" => $userData
            ]);
        } else {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
        }
    } else {
        echo json_encode(["message" => "Please provide username and password"]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "DB Error: " . $e->getMessage()]);
}