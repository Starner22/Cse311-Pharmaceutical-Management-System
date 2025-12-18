<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);

?>

<!DOCTYPE HTML>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Page</title>
        <link rel="stylesheet" href="http://localhost/Trial/Styles/Admin_Add_Edit_Data_Start_Styles.css">
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

        
        <div class = "Main_Content">
                <div class="medicines_box">
                    <a href= "http://localhost/Trial/Admin/Admin_Edit_Medicine_Intermediate.php">
                        <button class="medicines_button"> Edit Medicine </button>
                    </a>
                </div>

                <div class="companies_box">
                    <a href= "http://localhost/Trial/Admin/Admin_Edit_Company_Intermediate.php">
                        <button class="companies_button"> Edit Company </button>
                    </a>
                </div>

                <div class="types_box">
                    <a href= "http://localhost/Trial/Admin/Admin_Edit_Type_Intermediate.php">
                        <button class="types_button"> Edit Type </button>
                    </a>
                </div>

                <div class="ways_box">
                    <a href= "http://localhost/Trial/Admin/Admin_Edit_Way_Intermediate.php">
                        <button class="ways_button"> Edit Way </button>
                    </a>
                </div>
            </div>

    </body>
</html>