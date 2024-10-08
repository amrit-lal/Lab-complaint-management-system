<?php
// Database connection script
$host = 'localhost';
$db = 'complaint_portal';
$user = 'root';
$password = '';  // Add your MySQL password if required

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
