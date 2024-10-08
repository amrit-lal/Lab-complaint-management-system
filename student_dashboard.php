<?php
session_start();
if ($_SESSION['user_type'] != 'student') {
    header('Location: index.php');
    exit();
}

include('db.php');
$student_id = $_SESSION['user_id'];
$query = "SELECT * FROM complaints WHERE student_id = $student_id";
$result = $conn->query($query);

?>
<?php include('templates/header.php'); ?>
<h2>Your Complaints</h2>
<table>
    <tr>
        <th>PC Number</th>
        <th>Room Number</th>
        <th>Components</th>
        <th>Description</th>
        <th>Status</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['pc_number']; ?></td>
            <td><?php echo $row['room_number']; ?></td>
            <td><?php echo $row['components']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="add_complaint.php">Add a new complaint</a>
<a href="logout.php">Logout</a>
<?php include('templates/footer.php'); ?>
