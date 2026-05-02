<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Включаем отображение ошибок для контроля
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Подключаем твои системные файлы
require_once __DIR__ . '/../config/config.php'; 
require_once __DIR__ . '/../classes/database.php'; 

try {
    // Используем подключение из твоего конфига
    $databaseConnection = isset($db) ? $db : $GLOBALS['db'];

    if (!$databaseConnection) {
        throw new Exception("Database connection variable not found.");
    }

    $database = new Database($databaseConnection);
    $connection = $database->getConnection();

    // Получаем ID студента из ссылки (например, 27 или 17)
    $student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;

    if (!empty($student_id)) {
        // УЛУЧШЕННЫЙ ЗАПРОС:
        // Выбирает уроки, закрепленные за этим ID (например, 7)
        // И ПЛЮС все уроки, которые общие для всех (где user_id IS NULL)
        $query = "SELECT subject_name, class_day, start_time, end_time, room_number, class_type 
                  FROM timetable 
                  WHERE user_id = :student_id OR user_id IS NULL 
                  ORDER BY FIELD(class_day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'), start_time";

        $stmt = $connection->prepare($query);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();

        $schedule = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Отдаем результат в Ionic
        echo json_encode($schedule);
    } else {
        echo json_encode(["message" => "Student ID is missing in the request"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "System error: " . $e->getMessage()]);
}
?>