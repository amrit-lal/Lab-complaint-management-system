<?php include('templates/header.php'); ?>
<h2>Login to Complaint Portal</h2>
<form action="login.php" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Login</button>
</form>
<a href="register.php">Register</a>
<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email=$_POST['email'];


    $query = "SELECT * FROM users WHERE  username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user['user_type']; 
            echo "$email";
            $u=$user['email'];
            echo "$u";
            if($email==$user['email']){

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
        }
        else
        {echo"invalid email";}
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username.";
    }
}
?>
