<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pms_db");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch the user from the database
    $sql = "SELECT * FROM admin WHERE Username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $admin['Password'])) {
            // If valid, start a session and redirect to the dashboard
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['username'] = $admin['Username'];
            header("Location: Admin_Dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/Trial/Styles/Admin_Login_Styles.css">
    <title>Login - Pharmaceutical Management System</title>
    
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="http://localhost/Trial/Admin/Admin_Login.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="http://localhost/Trial/Public/FrontPage.php">Back to Home</a>
    </div>
</body>
</html>