<?php 
    $conn = new mysqli("localhost", "root", "", "pms_db");
    
    $id = $_GET['id'];

    $sql = "DELETE FROM Company WHERE Company_id = '$id'";
    $conn->query($sql);

    header("Location: Admin_Edit_Company_Intermediate.php");
?>