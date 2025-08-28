<?php
// Database connection parameters
$servername = "localhost";
$username = "kumuduho_carpark";
$password = "kumuduho_carpark";
$dbname = "kumuduho_carpark";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data from the table
$sql = "SELECT id, vehicle_number, tel_number, date_time, exit_time, parking_fee, status FROM parking ORDER BY parking.date_time DESC LIMIT 0, 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Output data of each row in a table format
  echo "<style>
          table {
            border-collapse: collapse;
            width: 100%;
            background-color: #212121;
            color: white;
          }
          th, td {
            border: 1px solid #ffffff45;
            padding: 8px;
            text-align: left;
          }
          th {
            background-color: #424242;
          }
          tr:nth-child(even) {
            background-color: #616161;
          }

          @media (max-width: 768px) {
            table, th, td {
              font-size: 12px;
            }
          }
        </style>";
        echo "<h2 style='text-align:center; '>Car Parking Real Time Database</h2>";
  echo "<table><tr><th>ID</th><th>Vehicle Number</th><th>Phone Number</th><th>Entrance Time</th><th>Exit Time</th><th>Parking Fee</th><th>Status</th></tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row["id"]."</td><td>".$row["vehicle_number"]."</td><td>".$row["tel_number"]."</td><td>".$row["date_time"]."</td><td>".$row["exit_time"]."</td><td>".$row["parking_fee"]."</td><td>".$row["status"]."</td></tr>";
  }
  echo "</table>";
} else {
  echo "0 results";
}
$conn->close();
?>
