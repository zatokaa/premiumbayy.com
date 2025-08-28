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
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
        }
        h2 {
            text-align: center;
        }
        form {
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="submit"] {
            width: calc(100% - 22px); /* Adjusted width to fit within the frame */
            padding: 10px;
            margin-bottom: 10px; /* Added margin-bottom */
            border: none;
            border-radius: 5px;
        }
        input[type="submit"] {
            display: block;
            margin: 0 auto; /* Center the submit button */
            background-color: #4CAF50;
            color: #fff;
            font-weight:700;
            font-size:20px;
            cursor: pointer;
            margin-top: 10px; /* Added margin-bottom */
             padding: 10px 20px; /* Add padding to the button */
}

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        

    </style>
</head>
<body>
    <div class="container">
        <h2>Car Park Entrance</h2>
        <form action="process_entrance.php" method="post">
            <label for="vehicle_number">Vehicle Number:</label>
            <input type="text" id="vehicle_number" name="vehicle_number">
            <label for="tel_number">Telephone Number:</label>
            <input type="text" id="tel_number" name="tel_number">
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
