<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);

    $way_id = $_GET['id'];

    $way = $conn->query("SELECT w1.Name as way_in, w1.logo as logo
                        FROM way w1
                        WHERE w1.way_id = $way_id");
    $way_result = $way->fetch_assoc();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $way_name= $_POST['way_name'];
        $way_logo= $_POST['way_logo'];

        $sql = "UPDATE way SET Name = '$way_name', Logo = '$way_logo' WHERE Way_ID = $way_id";
        $conn->query($sql);

        echo "<p> Way edited </p>";
        Header("Location: http://localhost/Trial/Admin/Admin_Edit_Way_Intermediate.php");

        
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


        <form action="Admin_Edit_Way.php?id= <?php echo "$way_id"?>" method="POST">
            <div class= "Encapsulate">

                Way Name: <?php echo '<input  name="way_name" class="Way_Name_Bar" value="' .$way_result['way_in']. '" required>'; ?>
                <br>
                Logo: <input type="file" name="way_logo" class="Way_Logo_Bar" enctype="multipart/form-data">
                <br> 

                <button type="submit" name="submit_way"  class="Submit_Button">Edit Way</button>
            </div>
        </form>