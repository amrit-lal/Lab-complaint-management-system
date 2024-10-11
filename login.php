<?php include('templates/header.php'); ?>
<h2>Login to Complaint Portal</h2>
<form action="login.php" method="POST">
<input type="email" name="email" placeholder="Email" required>
 <input type="password" name="password" placeholder="Password" required>
 <button type="submit">Login</button>
</form>
<a href="register.php">Register</a>
<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $password = $_POST['password'];
    $email=$_POST['email'];


    $query = "SELECT * FROM users WHERE  email= '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user['user_type']; 
            // Redirect user to appropriate dashboard
            switch ($user['user_type']) {
                case 'admin':
                    header('Location: admin_dashboard.php');
                    break;
                case 'HOD':
                    header('Location: hod_dashboard.php');
                    break;
                case 'supervisor':
                    header('Location: supervisor_dashboard.php');
                    break;
                default:
                    header('Location: student_dashboard.php');
            }
        
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid email.";
    }
}
?>
