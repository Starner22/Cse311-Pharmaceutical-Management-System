<?php 
    $conn = new mysqli("localhost", "root", "", "pms_db");
    
    $id = $_GET['id'];

    $sql = "DELETE FROM way WHERE way_id = '$id'";
    $conn->query($sql);

    header("Location: Admin_Edit_Way_Intermediate.php");
?>