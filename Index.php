<?php

        $conn = new mysqli("localhost", "root", "", "pms_db");
        if ($conn->connect_error) 
            die("Connection failed: " . $conn->connect_error);

        Header("Location: http://localhost/Trial/Public/FrontPage.php");
?>