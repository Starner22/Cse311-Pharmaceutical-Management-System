<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $company_name= $_POST['company_name'];
        $company_address= $_POST['company_address'];
        $company_contact= $_POST['company_contact'];

        $sql = "INSERT INTO company(Name, HQ_Address, Contact) VALUES ('$company_name', '$company_address', '$company_contact')";
        $conn->query($sql);

        echo "<p> Company added </p>";
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

        <form action="Admin_Add_Company.php" method="POST">
            <div class= "Encapsulate">

                Company Name: <input  name="company_name" class="Company_Name_Bar" placeholder="Company Name" required>
                <br>
                Headquarter Address: <textarea name="company_address" class="Company_Address_Bar" placeholder="Address (Optional)"></textarea>
                <br>
                Contact: <input name="company_contact" class="Company_Contact_Bar" placeholder="Contact Number (Optional)">
                <br>
                <button type="submit" name="submit_company" class="Submit_Button">Add Company</button>
            </div>

        </form>