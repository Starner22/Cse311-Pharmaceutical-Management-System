<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $type_name= $_POST['type_name'];
        $type_address= $_POST['type_details'];

        $sql = "INSERT INTO Types(Name, Details) VALUES ('$type_name', '$type_address')";
        $conn->query($sql);

        echo "<p> Type added </p>";
        Header("Location: Admin_Add_data.php");
    }
?>

<!DOCTYPE HTML>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Page</title>
        <link rel="stylesheet" href="http://localhost/Trial/Styles/Admin_Add_Edit_Data_Final_Styles.css">
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

        <form action="Admin_Add_Type.php" method="POST">
            <div class= "Encapsulate">

                Type Name: <input  name="type_name" class="Type_Name_Bar" placeholder="Type Name" required>
                <br>
                Details: <textarea name="type_details" class="Type_Details_Bar" placeholder="Details (Optional)"></textarea>
                <br>

                <button type="submit" name="submit_type" class="Submit_Button">Add Type</button>
            </div>

        </form>