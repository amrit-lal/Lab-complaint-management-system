<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'supervisor') {
    header('Location: login.php');
    exit;
}

include('db.php');

// Handle status update
if (isset($_POST['update_status'])) {
    $complaint_id = $_POST['complaint_id'];
    $new_status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE complaints SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $new_status, $complaint_id);
    $stmt->execute();

    // Set success message in session
    $_SESSION['message'] = "Complaint status updated successfully!";
    header('Location: admin_dashboard.php'); // Refresh the page after update
    exit;
}

// Fetch complaints data
$query = "SELECT complaints.*, users.username ,users.email FROM complaints JOIN users ON complaints.student_id = users.id";
$result = $conn->query($query);
?>

<?php include('templates/header.php'); ?>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert success-alert">
        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<h2>SUPERVISER Dashboard - Manage Complaints</h2>

<table>
    <tr>
        <th>PC Number</th>
        <th>Room Number</th>
        <th>Components</th>
        <th>Description</th>
        <th>complaint Time</th>
        <th>Status</th>
        <th>Student</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <form method="POST" action="admin_dashboard.php">
                <td><?php echo $row['pc_number']; ?></td>
                <td><?php echo $row['room_number']; ?></td>
                <td><?php echo $row['components']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['created_at']; ?></td> 
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                
                <td>
                    <input type="hidden" name="complaint_id" value="<?php echo $row['id']; ?>">
                    
                </td>
            </form>
        </tr>
    <?php endwhile; ?>
</table>

<a href="logout.php">Logout</a>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const alertBox = document.querySelector('.alert');
    if (alertBox) {
        setTimeout(function() {
            alertBox.style.display = 'none';
        }, 3000); // Hide after 3 seconds
    }

    // Handle enabling/disabling the update button when status changes
    
        
    
});
</script>

<?php include('templates/footer.php'); ?>
