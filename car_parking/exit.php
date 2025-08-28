<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Park Exit</title>
    <style>
        body {
            background-color: #222;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        h2 {
            margin-top: 50px;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"], input[type="submit"] {
            width: 300px;
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
            font-weight:700;
            font-size:16px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Car Park Exit</h2>
    <form action="process_exit.php" method="post">
        Vehicle Number: <input type="text" name="vehicle_number"><br>
        <input type="submit" value="Submit and Pay">
    </form>
</body>
</html>
