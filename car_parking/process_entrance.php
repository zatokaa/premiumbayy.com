<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Park Entrance</title>
    <style>
        body {
            background-color: #222;
            color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
            padding: 0;
            display: block;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
        }
        .message p {
            margin: 0;
            color: #fff;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            font-weight:700;
            font-size:15px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top:20px;
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

        // Update status in status table to 0 (Entrance submission)
        $sql_update_status = "UPDATE status SET vehicle_status=0";
        if ($conn->query($sql_update_status) === TRUE) {
            
            echo "<p style='color: green;font-size:20px;font-weight:700;'>Park your vehicle in an empty slot</p>";
            
        } else {
            echo "<p style='color: red;'>Error updating status record: " . $conn->error . "</p>";
        }

        $vehicle_number = $_POST['vehicle_number'];
        $tel_number = $_POST['tel_number'];
        $date_time = date('Y-m-d H:i:s');

        // Insert entrance data into parking table
        $status = 0;
        $sql_insert_parking = "INSERT INTO parking (vehicle_number, tel_number, date_time, status)
                VALUES ('$vehicle_number', '$tel_number', '$date_time', '$status')";

        if ($conn->query($sql_insert_parking) === TRUE) {
            // echo "<p style='color: green;'>Entrance data submitted successfully</p>";
            echo "";
            echo "<H3 style='color: white;'>Vehicle Number: $vehicle_number</H3>";
            echo "";
             echo "<H5 style='color: white;'>Entrance Time: $date_time</H5>";
            echo "";
            echo "<p style='color: red;font-size:13px;'>After parking, Click the confirm button.</p>";
             echo "";
             echo "";
            echo "<form action='confirm_entrance.php' method='post'>
                    <input type='hidden' name='vehicle_number' value='$vehicle_number'>
                    <input type='hidden' name='date_time' value='$date_time'>
                    <input type='submit' value='Confirm'>
                  </form>";
                  
        } else {
            echo "<p style='color: red;'>Error: " . $sql_insert_parking . "<br>" . $conn->error . "</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
