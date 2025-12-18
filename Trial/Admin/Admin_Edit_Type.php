<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);

    $type_id = $_GET['id'];

    $type = $conn->query("SELECT t1.Name as type_in, t1.details as details_in
                        FROM types t1
                        WHERE t1.type_id = $type_id");
    $type_result = $type->fetch_assoc();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $type_name= $_POST['type_name'];
        $type_details= $_POST['type_details'];

        $sql = "UPDATE types SET Name = '$type_name', Details = '$type_details' WHERE Type_ID = $type_id";
        $conn->query($sql);

        echo "<p> Type edited </p>";
        Header("Location: http://localhost/Trial/Admin/Admin_Edit_Type_Intermediate.php");
  
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


        <form action="Admin_Edit_Type.php?id= <?php echo "$type_id"?>" method="POST">
            <div class= "Encapsulate">

                Type Name: <?php echo '<input  name="type_name"  class="Type_Name_Bar" value="' .$type_result['type_in']. '" required>'; ?>
                <br>
                Details: <textarea name="type_details" class="Type_Details_Bar"><?php echo isset($type_result['details_in']) ? $type_result['details_in'] : ''; ?></textarea>
                <br>

                <button type="submit" name="submit_type">Edit Type</button>
            </div>
        </form>