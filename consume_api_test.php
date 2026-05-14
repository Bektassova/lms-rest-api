<?php
/**
 * PART 3: Consuming an API through cURL
 * This script demonstrates how an external PHP system can consume 
 * the get_timetable endpoint.
 */

// 1. The URL of the endpoint we want to consume
$api_url = "http://localhost:8888/lms-rest-api/endpoints/get_timetable.php?student_id=27";

// 2. Initialize a cURL session
$ch = curl_init();

/**
 * 3. Set cURL options
 * CURLOPT_URL: The endpoint to contact
 * CURLOPT_RETURNTRANSFER: Return the response as a string instead of outputting it
 * CURLOPT_HTTPGET: Use the GET request type
 */
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPGET, true);

// 4. Execute the request and store the response
$response = curl_exec($ch);

// 5. Handle potential errors during the request
if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch);
} else {
    // 6. Get the HTTP response code (Requirement: SE2/AA2)
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // 7. Decode the JSON response into a PHP array
    $data = json_decode($response, true);

    echo "<h2>MCAST Task 2 - Part 3: API Consumption Result</h2>";
    echo "<p>HTTP Response Code: <strong>$httpCode</strong></p>";
    
    if ($httpCode == 200 && !empty($data)) {
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr><th>Subject</th><th>Day</th><th>Time</th><th>Room</th></tr>";
        
        foreach ($data as $item) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($item['subject_name']) . "</td>";
            echo "<td>" . htmlspecialchars($item['class_day']) . "</td>";
            echo "<td>" . htmlspecialchars($item['start_time']) . " - " . htmlspecialchars($item['end_time']) . "</td>";
            echo "<td>" . htmlspecialchars($item['room_number']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Failed to retrieve data or empty response.</p>";
    }
}

// 8. Close the cURL session to free up system resources
curl_close($ch);
// ========== POST REQUEST ==========


echo "<hr><h2>POST Request – Create a new user</h2>";

// 2. POST example
$post_url = "http://localhost:8888/lms-rest-api/endpoints/users.php";
$post_data = json_encode([
    "username" => "new_student",
    "password" => "secret123",
    "firstName" => "John",
    "lastName" => "Doe",
    "email" => "john@example.com",
    "role" => "student"
]);

$ch_post = curl_init();
curl_setopt($ch_post, CURLOPT_URL, $post_url);
curl_setopt($ch_post, CURLOPT_POST, true);
curl_setopt($ch_post, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch_post, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_post, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json"
]);

$post_response = curl_exec($ch_post);
$post_http = curl_getinfo($ch_post, CURLINFO_HTTP_CODE);
curl_close($ch_post);

echo "<p>HTTP Code: $post_http</p>";
$post_result = json_decode($post_response, true);
echo "<pre>" . print_r($post_result, true) . "</pre>";

// ========== 3. PUT request – update course ==========
echo "<hr><h2>PUT Request – Update course with id=10</h2>";

$put_url = "http://localhost:8888/lms-rest-api/endpoints/courses.php?id=10";
$put_data = json_encode([
    "course_name" => "English Advanced"
]);

$ch_put = curl_init();
curl_setopt($ch_put, CURLOPT_URL, $put_url);
curl_setopt($ch_put, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch_put, CURLOPT_POSTFIELDS, $put_data);
curl_setopt($ch_put, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_put, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: application/json"
]);

$put_response = curl_exec($ch_put);
$put_http = curl_getinfo($ch_put, CURLINFO_HTTP_CODE);
curl_close($ch_put);

echo "<p>HTTP Code: $put_http</p>";
echo "<pre>" . print_r(json_decode($put_response, true), true) . "</pre>";

// ========== 4. DELETE request – remove assignment ==========
echo "<hr><h2>DELETE Request – Remove assignment with id=5</h2>";

$delete_url = "http://localhost:8888/lms-rest-api/endpoints/assignments.php?id=5";

$ch_delete = curl_init();
curl_setopt($ch_delete, CURLOPT_URL, $delete_url);
curl_setopt($ch_delete, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch_delete, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_delete, CURLOPT_HTTPHEADER, [
    "Accept: application/json"
]);

$delete_response = curl_exec($ch_delete);
$delete_http = curl_getinfo($ch_delete, CURLINFO_HTTP_CODE);
curl_close($ch_delete);

echo "<p>HTTP Code: $delete_http</p>";
echo "<pre>" . print_r(json_decode($delete_response, true), true) . "</pre>";

?>