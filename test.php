<?php
// 1. Define the API endpoint URL
$url = "http://localhost:8888/lms-rest-api/users";

// 2. Initialize cURL session
$ch = curl_init($url);

// 3. Set options: return the response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 4. Execute the request and store the response
$response = curl_exec($ch);

// 5. Close cURL session
curl_close($ch);

// 6. Decode JSON response into an associative array
$users = json_decode($response, true);

// 7. Display the data in an HTML table
echo "<h2>LMS Users List</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr style='background-color: #f2f2f2;'>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Role</th>
      </tr>";

if (!empty($users)) {
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . $user['user_id'] . "</td>";
        echo "<td>" . $user['name'] . " " . $user['surname'] . "</td>";
        echo "<td>" . $user['email'] . "</td>";
        echo "<td>" . $user['role'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No users found</td></tr>";
}
echo "</table>";
?>