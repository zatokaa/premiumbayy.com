<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Park Exit Confirmation</title>
    <style>
        body {
            background-color: #222;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .message {
            margin-top: 50px;
        }
        form {
            margin-top: 20px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size:16px;
            font-weight:700;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
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

        if ($conn->connect_error) {
            die("<p style='color: red;'>Connection failed: " . $conn->connect_error . "</p>");
        }

        // Update status in status table to 0 (Exit submission)
        $sql_update_status = "UPDATE status SET vehicle_status=0";
        if ($conn->query($sql_update_status) === TRUE) {
            echo "";
        } else {
            echo "<p>Error updating status record: " . $conn->error . "</p>";
        }

                 $vehicle_number = $_POST['vehicle_number'];

            // Update status and exit_time in parking table
            
                $current_time = date('Y-m-d H:i:s');
                $sql_update_parking = "UPDATE parking SET status=1, exit_time='$current_time' WHERE vehicle_number='$vehicle_number' AND status=0";

        if ($conn->query($sql_update_parking) === TRUE) {
            echo "<h2>Successfully Paid</h2>";
            echo "<h1>60LKR</h1>";
            echo "<p>Press Exit button to Confirm Exit</p>";
            echo "<form action='pay_and_confirm.php' method='post'>
                    <input type='hidden' name='vehicle_number' value='$vehicle_number'>
                    <input type='submit' value='Confirm Exit'>
                  </form>";
        } else {
            echo "<p>Error updating parking record: " . $conn->error . "</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
