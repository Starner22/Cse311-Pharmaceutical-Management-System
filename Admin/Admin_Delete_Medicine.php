<?php 
    $conn = new mysqli("localhost", "root", "", "pms_db");
    
    $id = $_GET['id'];

    $sql = "DELETE FROM medicine WHERE Medicine_ID = '$id'";
    $conn->query($sql);

    header("Location: Admin_Edit_Medicine_Intermediate.php");
?>