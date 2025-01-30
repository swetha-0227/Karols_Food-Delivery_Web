<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";
$port = "33066";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // Check if input is empty
    if (empty($user) || empty($pass)) {
        echo "<script>alert('Please fill all fields!'); window.location.href='login.php';</script>";
        exit();
    }

    // Secure query with prepared statement
    $sql = "SELECT * FROM register WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($pass, $row['password'])) {
            $_SESSION['username'] = $username; // Replace $username with the actual logged-in username from your database.
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='login.php';</script>";
        exit();
    }

    $stmt->close();
}
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f4f4f4;
             display: flex;
              justify-content: center; 
              align-items: center; 
              height: 100vh; 
        }
        .form-container { 
            background:rgb(255, 251, 251) ;
             padding: 20px;
              border-radius: 10px;
               box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
               margin-right: 10px;
            }
        input { 
            width: 95%; 
            padding: 10px; 
            margin: 10px 0px; 
            border: 1px solid #ccc; 
            border-radius: 5px;
            margin-right: 10px;
         }
        button { 
            width: 100%;
             padding: 10px;
             background: #FF645A; 
             color: white; 
             border: none;
              border-radius: 5px; 
              cursor: pointer;
             }
        button:hover { 
            background: #040404; 
        }
        a { 
             color: #FF645A; 
            }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit">Login</button>
            <p><a href="reg.html">Don't have an account? Register</a></p>
        </form>
    </div>
</body>
</html>
