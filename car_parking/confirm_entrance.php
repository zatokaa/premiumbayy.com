<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Park Entrance Confirmation</title>
    <style>
        body {
            background-color: #222;
            color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            display: block;
            margin-top:20px;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin: 15px;
        }
        .message p {
            margin: 0;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="message">
        <?php
        $servername = "localhost";
        $username = "kumuduho_carpark";
        $password = "kumuduho_carpark";
        $dbname = "kumuduho_carpark";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("<p style='color: red;'>Connection failed: " . $conn->connect_error . "</p>");
        }

        // Update status in status table to 1 (Entrance confirmation)
        $sql_update_status = "UPDATE status SET vehicle_status=1";
        if ($conn->query($sql_update_status) === TRUE) {
            echo "<h3 style='color: green;'>You've parked your Vehicle successfully.</h3>";
        } else {
            echo "<p style='color: red;'>Error updating status record: " . $conn->error . "</p>";
        }

        $vehicle_number = $_POST['vehicle_number'];
        $date_time = $_POST['date_time'];

        // Update status in parking table
        $sql_update_parking = "UPDATE parking SET status=1 WHERE vehicle_number='$vehicle_number' AND date_time='$date_time'";
        if ($conn->query($sql_update_parking) === TRUE) {
            echo "<p style='color: green;'>Thank You!</p>";
        } else {
            echo "<p style='color: red;'>Error updating parking record: " . $conn->error . "</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
