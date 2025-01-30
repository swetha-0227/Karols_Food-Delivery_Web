<?php
$servername = "localhost";
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "admin";
$port = "33066";

$conn = new mysqli($servername, $username, $password, $dbname,$port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    
    // Handle File Upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file);

    // Insert into database
    $sql = "INSERT INTO seller (name, email, product_name, product_price, product_image) 
            VALUES ('$name', '$email', '$product_name', '$product_price', '$target_file')";

    if ($conn->query($sql) === TRUE) {
        header("location: dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Registration</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 50px;
            color: #FF645A;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="file"] {
            border: none;
        }

        button {
            width: 100%;
            background-color: #FF645A;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
            transition: 0.3s ease;
        }

        button:hover {
            background-color: #e74c3c;
        }
    </style>

</head>
<body>
    
<div class="form-container">
    <h2>Seller Registration</h2>
    <form action="sellerreg.php" method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Product Name:</label>
        <input type="text" name="product_name" required><br><br>

        <label>Product Price:</label>
        <input type="number" step="0.01" name="product_price" required><br><br>

        <label>Product Image:</label>
        <input type="file" name="product_image" required><br><br>

        <button type="submit" name="register">Register</button>
    </form>
    </div>
</body>
</html>

