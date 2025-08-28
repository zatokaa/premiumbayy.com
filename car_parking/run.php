<?php
// Database connection parameters
$servername = "localhost";
$username = "kumuduho_carpark";
$password = "kumuduho_carpark";
$database = "kumuduho_carpark";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data from your table
$sql = "SELECT vehicle_status FROM status";
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Array to hold the status data
    $statuses = array();

    // Fetch status data from each row and add it to the array
    while($row = $result->fetch_assoc()) {
        $statuses = $row['vehicle_status'];
    }

    // Convert the statuses array to JSON format
    $json_data = json_encode($statuses, JSON_NUMERIC_CHECK);

    // Set response headers to indicate JSON content type
    header('Content-Type: application/json');

    // Output the JSON data
    echo $json_data;
} else {
    // No data found
    echo "No data found";
}

// Close connection
$conn->close();
?>