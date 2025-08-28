<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
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

// Update status in status table to 1 (Payment)
$sql_update_status = "UPDATE status SET vehicle_status=1";


if ($conn->query($sql_update_status) === TRUE) {
    echo "<h3>Payment Confirmed Successfully!</h3>";
    echo "";
    echo "<h2 style='color:green;'>You're good to GO.</h2>";
} else {
    echo "<p>Error updating status record: " . $conn->error . "</p>";
}


$conn->close();
?>

    </div>
</body>
</html>
