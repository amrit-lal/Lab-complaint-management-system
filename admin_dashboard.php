<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
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

<h2>Admin Dashboard - Manage Complaints</h2>
<a href=" admin_register.php"> FOR ADMIN Register</a>

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
                
                <td>
                    <select name="status" class="status-dropdown" data-original-status="<?php echo $row['status']; ?>">
                        <option value="pending" <?php if ($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="verified" <?php if ($row['status'] == 'verified') echo 'selected'; ?>>Verified</option>
                        <option value="resolved" <?php if ($row['status'] == 'resolved') echo 'selected'; ?>>Resolved</option>
                    </select>
                </td>

                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                
                <td>
                    <input type="hidden" name="complaint_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="update_status" class="update-btn">Update</button>
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
    const dropdowns = document.querySelectorAll('.status-dropdown');
    dropdowns.forEach(function(dropdown) {
        const updateBtn = dropdown.closest('form').querySelector('.update-btn');
        const originalStatus = dropdown.getAttribute('data-original-status');

        dropdown.addEventListener('change', function() {
            if (dropdown.value !== originalStatus) {
                updateBtn.disabled = false; // Enable the update button
            } else {
                updateBtn.disabled = true;  // Disable the update button if reverted
            }
        });
    });
});
</script>

<?php include('templates/footer.php'); ?>
