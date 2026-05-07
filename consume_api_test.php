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
?>