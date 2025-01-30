<?php
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "admin";
$port = 33066;  // Use your MySQL port

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>