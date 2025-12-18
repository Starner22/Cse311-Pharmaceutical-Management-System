<?php
$conn = new mysqli("localhost", "root", "", "pms_db");
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username     = ($_POST['username']);
    $email    = ($_POST['email']);
    $contact = ($_POST['contact']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO admin (Username, Password, Email, Contact) VALUES ('$username', '$password', '$email', '$contact')";

    if ($conn->query($sql)) {
        echo "Admin added";
        Header("Location: Admin_Dashboard.php");
    } else {
        echo "$conn->error";
    }
}
?>

<!DOCTYPE HTML>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Page</title>
        <link rel="stylesheet" href="http://localhost/Trial/Styles/Admin_Add_Admin_Styles.css">
    </head>
    <body>
        <div class = "Sidebar">
            <a href="http://localhost/Trial/Admin/Admin_Dashboard.php">Dashboard</a>
            <a href="http://localhost/Trial/Admin/Admin_Profile.php">Profile</a>
            <a href="http://localhost/Trial/Admin/Admin_Add_Admin.php">Add Admin</a>
            <a href="http://localhost/Trial/Admin/Admin_Add_Data.php">Add Data</a>
            <a href="http://localhost/Trial/Admin/Admin_Edit_Data.php">Edit Data</a>
            <a href= "http://localhost/Trial/Public/FrontPage.php">Logout</a>
        </div>

        <div class="Main_Content">
            <div class="Encapsulate">
                <h class="Call"> Add Admin </h>

                <form action="Admin_Add_Admin.php" method="POST" class="Admin_Form">
                    <input name="username" placeholder="Username" class="User_Name_Bar" required><br>
                    <input type="password" name="password" class="Password_Bar" placeholder="Password" required><br>
                    <input type="email" name="email" class="Email_Bar" placeholder="Email" required><br>
                    <input  name="contact" class="Contact_Bar" placeholder="Contact" required><br>

                    <button type="submit" name="submit_admin" class="Submit_Button">Add Admin</button>
                </form>
            </div>
        </div>
    </body>
</html>