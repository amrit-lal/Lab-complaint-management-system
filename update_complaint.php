<?php
session_start();
if ($_SESSION['user_type'] != 'admin') {
    header('Location: index.php');
    exit();
}

include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $complaint_id = $_POST['complaint_id'];
    $status = $_POST['status'];

    $query = "UPDATE complaints SET status = '$status' WHERE id = $complaint_id";
    if ($conn->query($query)) {
        header('Location: admin_dashboard.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
