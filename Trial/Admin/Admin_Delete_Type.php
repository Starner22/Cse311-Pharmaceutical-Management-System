<?php 
    $conn = new mysqli("localhost", "root", "", "pms_db");
    
    $id = $_GET['id'];

    $sql = "DELETE FROM types WHERE type_id = '$id'";
    $conn->query($sql);

    header("Location: Admin_Edit_Type_Intermediate.php");
?>