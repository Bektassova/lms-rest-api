<?php
// --- НАСТРОЙКИ ДОСТУПА (CORS) ---
header("Access-Control-Allow-Origin: *"); // Разрешаем любым приложениям (Ionic) обращаться к API
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Разрешаем типы запросов
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Разрешаем передачу заголовков
header("Content-Type: application/json; charset=UTF-8"); // ответ будет в формате JSON (как данные)

// Если Ionic просто проверяет связь (метод OPTIONS), то сразу отвечаем "ОК" и выходим
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 1. Manually set MAMP credentials (to avoid the "array" error)подключение к базе (MySQL)
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

    // 3. Include only the User class-тут подключается логика пользователя
    require_once __DIR__ . '/../classes/User.php';
    $user = new User($db);

    // 4. Handle Login-“сервер получил email/password”
    // ВАЖНО: берем данные из "потока", так как Ionic присылает JSON-пакет
    $data = json_decode(file_get_contents('php://input'), true);

    //— проверка входных данных: есть ли логин, пароль
    //-мне вообще дали логин и пароль?
    if (isset($data['username']) && isset($data['password'])) {
        
        $userData = $user->login($data['username'], $data['password']); //ВЫЗОВ ЛОГИНА (самое главное)

        //-если логин успешен=>“вход разрешён”
        if ($userData) {
            echo json_encode([
                "status" => "success",
                "message" => "Login successful",
                "user" => $userData
            ]);
        } else {
            // http_response_code(401); // Закомментировал, чтобы Ionic не пугался раньше времени
            echo json_encode([
                "status" => "error", 
                "message" => "Invalid credentials"
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Please provide username and password"
        ]);
    }

// ОШИБКА БАЗЫ:“500 ошибка сервера”
} catch (PDOException $e) {
    // http_response_code(500); 
    echo json_encode([
        "status" => "error",
        "message" => "DB Error: " . $e->getMessage()
    ]);
}
?>