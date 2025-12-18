<?php

        $conn = new mysqli("localhost", "root", "", "pms_db");
        if ($conn->connect_error) 
            die("Connection failed: " . $conn->connect_error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/Trial/Styles/Frontpage_Styles.css">
    <title>Pharmaceutical Management System</title>


    <script>
        function toggleMenu() {
            const menuContent = document.querySelector('.menu-content');
            menuContent.style.display = menuContent.style.display === 'block' ? 'none' : 'block';
        }

        function toggleLoginForm() {
            const loginForm = document.querySelector('.login-form');
            loginForm.style.display = loginForm.style.display === 'none' ? 'block' : 'none';
        }
    </script>


</head>


<body>
    <header>
        <!-- Left Side: Logo and Title -->
        <div class="logo-container">
            <h1>Pharmaceutical Management System</h1>
        </div>
        
        <!-- Right Side: Navigation Menu -->
        <nav>
            <ul>
                <a href="http://localhost/Trial/Public/FrontPage.php">Home</a>
                <a href="http://localhost/Trial/Public/Company_Database.php">Company</a>
                <a href="http://localhost/Trial/Public/Medicine_Database.php">Medicine</a>
                <a href="http://localhost/Trial/Public/Medicine_Type_Database.php">Drug Type</a>
                <a href="http://localhost/Trial/Admin/Admin_Login.php" onclick="toggleLoginForm()">Login</a>
            </ul>
        </nav>
    </header>

    <!-- Main Content Sections -->
    <section id="home" class="container">
        <h2>Welcome to the Pharmaceutical Management System</h2>
        <p>Your one-stop solution for managing pharmaceutical data efficiently and effectively.</p>
    </section>

    <section id="search" class="container">
        <h2>Search</h2>
        <p>Search for medicines by brand name, generic name, or drug class.</p>
    
        <div class= "Main_Content_1">
                <form action="http://localhost/Trial/Public/Search_Data.php" method="GET" class="Search_Form">
                    <div class="search_select">
                        <input type="radio" name="category" id="select_1" class="select_1" value="medicines" checked>
                        <label for="select_1" class="label_1">Medicine</label>

                        <input type="radio" name="category" id="select_2" class="select_2" value="companies">
                        <label for="select_2" class="label_2">Company</label>
                    </div>

                    <input name="search" class="Search_Bar" placeholder="Search?" required>
                    <button type="submit" class="Search_button"> Search </button>
                </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Pharmaceutical Management System. All rights reserved.</p>
    </footer>
</body>
</html>