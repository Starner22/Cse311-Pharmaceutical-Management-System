<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);

    $category = $_GET['category'];
    $search = ($_GET['search']);

    if($category === 'medicines'){
        $sql_1 = "SELECT m.medicine_ID as ID, m.Name AS name, m.dosage_value as dosage, m.price as price, m.date_created AS date_created, c.Name as company, w.Name as way, w.logo as logo, t.Name as type
                    FROM medicine m
                    JOIN company c ON m.company_id = c.company_id
                    JOIN way w ON m.way_id = w.way_id
                    JOIN types t ON m.type_id = t.type_id
                    WHERE m.Name LIKE '%$search%'";
        $result_medicine = $conn->query($sql_1);
    }

    if($category === 'companies'){
        $sql_2 ="SELECT  c.company_id AS id, c.name AS name, COUNT(m.company_id) AS med_count 
                    FROM company c
                    LEFT JOIN medicine m ON c.company_id = m.company_id 
                    WHERE c.Name LIKE '%$search%'
                    GROUP BY c.company_id";
        $result_company = $conn->query($sql_2);
    }

?>



<!DOCTYPE html>

    <head>
        <title>Search Results</title>
        <link rel="stylesheet" href="http://localhost/Trial/Styles/Search_Data_Styles.css">
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


    <div class= "Main_Content_1">
        <form action="http://localhost/Trial/Public/Search_Data.php" method="GET" class="Search_Form">
            <div class="search_select">
                <input type="radio" name="category" id="select_1" class="select_1" value="medicines" <?php if ($category === 'medicines') echo 'checked'; ?>>
                <label for="select_1" class="label_1">Medicine</label>

                <input type="radio" name="category" id="select_2" class="select_2" value="companies" <?php if ($category === 'companies') echo 'checked'; ?>>
                <label for="select_2" class="label_2">Company</label>
            </div>

            <input name="search" class="Search_Bar" value="<?php echo $search ?>" required>
            <button type="submit" class="Search_button"> Search </button>
        </form>
        </div>

        <div class ="Search">
            <?php  
                if($category === 'medicines'){
                    echo '<div class="container">';
                    if ($result_medicine->num_rows > 0) {
                        while ($row = $result_medicine->fetch_assoc()) {
                            echo "<div class='medicine-box'>";
                                echo "<a href='Medicine_Details.php?id=" . $row["ID"] . "' class='med-details'>";

                                    echo "<div class='box-header'>";
                                        echo "<div class='box-header-left'>";
                                            echo "<img src='http://localhost/Trial/Assets/logos/" . $row["logo"] . "' alt='" . $row["way"] . " logo' class='med-logo' />";
                                            echo "<b class='med-name'>" . $row["name"]. "</b>";
                                        echo "</div>";
                                        // echo "<p class='med-way'>" . $row["way"]. "</p>";
                                    echo "</div>";

                                    echo "<div class='box-middle'>";
                                        echo "<p class='med-dose'>Dose: " . $row["dosage"] . "</p>";
                                        echo "<p class='med-type'>" .$row["type"] . "</p>";
                                    echo "</div>";

                                    echo "<b class='med-company'> Company: " .$row["company"] . "</b>";
                                    

                                echo "</a>";

                            echo "</div>";
                        }
                    } else {
                        echo "<p>No medicines found</p>";
                    }
                echo '</div>';
                }

                elseif ($category === 'companies'){
                    echo '<div class="container">';
                    if ($result_company->num_rows > 0) { 
                        while ($row = $result_company->fetch_assoc()) {
                            echo "<div class='company-box'>"; 
                                echo "<a href='Medicine-Company_Intermediate.php?id=" . $row["id"] . "' class='company-details'>";

                                    echo "<div class='box-header'>";
                                        echo "<b class='company-name'>" . $row["name"] . "</b>";
                                        echo "<p class='medicine-count'>" . $row["med_count"] . " medicines". " </p>";
                                    echo "</div>";

                                echo "</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No companies found</p>";
                    }
                    echo '</div>';
                }

            ?>
        </div>
    </div>