<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirmpassword) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT email FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "Email already exists. Try another one.";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO register(username, email, password, confirm_password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $hashed_password);
        
        if ($stmt->execute()) {
            header("Location: dashboard.php");
    exit();
        } else {
            echo "Something went wrong. Try again!";
        }
    }
    $stmt->close();
    $conn->close();
}
?>