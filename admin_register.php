<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>
<?php include('templates/header.php'); ?>
<h2>User Registration</h2>
<form action="register.php" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
   <input type="email" name="email" placeholder="Email" required>

    <select name="user_type" required>
        <option value="student">Student</option>
        <option value="HOD">HOD</option>
        <option value="supervisor">Supervisor</option>
        <option value="admin">Admin</option>
    </select>
    <button type="submit">Register</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('db.php');

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];

    $query = "INSERT INTO users (username, password, email, user_type) VALUES ('$username', '$password','$email', '$user_type')";
    if ($conn->query($query)) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<?php include('templates/footer.php'); ?>
