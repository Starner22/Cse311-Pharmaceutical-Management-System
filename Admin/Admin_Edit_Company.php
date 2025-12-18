<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);

    $company_id = $_GET['id'];

    $company = $conn->query("SELECT c1.Name as company_in, c1.HQ_Address as address_in, c1.contact as contact_in, c1.company_id
                        FROM company c1
                        WHERE c1.company_id = $company_id");
    $company_result = $company->fetch_assoc();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $company_name= $_POST['company_name'];
        $company_address= $_POST['company_address'];
        $company_contact= $_POST['company_contact'];

        $sql = "UPDATE company SET Name = '$company_name', HQ_Address = '$company_address', Contact = '$company_contact' WHERE Company_ID = $company_id";
        $conn->query($sql);

        echo "<p> Company edited </p>";
        Header("Location: http://localhost/Trial/Admin/Admin_Edit_Company_Intermediate.php");

        
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


        <form action="Admin_Edit_Company.php?id= <?php echo "$company_id"?>" method="POST">
            <div class= "Encapsulate">

                Company Name: <?php echo '<input  name="company_name" class="Company_Name_Bar" value="' .$company_result['company_in']. '" required>'; ?>
                <br>
                Headquarter Address: <textarea name="company_address" class="Company_Address_Bar"><?php echo isset($company_result['address_in']) ? $company_result['address_in'] : ''; ?></textarea>
                <br>
                Contact: <input name="company_contact" class="Company_Contact_Bar" value = "<?php echo isset($company_result['contact_in']) ? $company_result['contact_in'] : ''; ?>">
                <br>
                <button type="submit" name="submit_company" class="Submit_Button">Edit Company</button>
            </div>
        </form>