<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);

    $sql_1 = $conn->query("SELECT COUNT(*) AS Total_1 FROM medicine");
        $temp_1 = $sql_1->fetch_assoc();
        $total_medicines = $temp_1['Total_1'];
    
    $sql_2 = $conn->query("SELECT COUNT(*) AS Total_2 FROM company");
        $temp_2 = $sql_2->fetch_assoc();
        $total_companies = $temp_2['Total_2'];

    $sql_3 = $conn->query("SELECT COUNT(*) AS Total_3 FROM types");
        $temp_3 = $sql_3->fetch_assoc();
        $total_types = $temp_3['Total_3'];

    $sql_4 = $conn->query("SELECT COUNT(*) AS Total_4 FROM way");
        $temp_4 = $sql_4->fetch_assoc();
        $total_ways = $temp_4['Total_4'];

    $sql_5 =  $conn->query("SELECT m.name AS name, m.price AS price, w.logo as logo , w.name AS way
                            FROM medicine m
                            JOIN way w ON m.way_id = w.way_id
                            ORDER BY m.Date_Created desc
                            LIMIT 4");
    
    $sql_6 =  $conn->query("SELECT  c.company_id AS id, c.name AS name, COUNT(m.company_id) AS med_count 
                            FROM company c
                            LEFT JOIN medicine m ON c.company_id = m.company_id 
                            GROUP BY c.company_id
                            ORDER BY c.Date_Created desc
                            LIMIT 4");
?>

<!DOCTYPE HTML>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Page</title>
        <link rel="stylesheet" href="http://localhost/Trial/Styles/Admin_Dashboard_Styles.css">
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

        <div class="Main_Container">
            <div class= "Main_Content_1"> <!-- Non-Fancy search button -->
                <form action="http://localhost/Trial/Admin/Admin_Search_Data.php" method="GET" class="Search_Form">
                    <div class="search_select">
                        <input type="radio" name="category" id="select_1" class="select_1" value="medicines" checked>
                        <label for="select_1" class="label_1">Medicine</label>

                        <input type="radio" name="category" id="select_2" class="select_2" value="companies">
                        <label for="select_2" class="label_2">Company</label>

                        <input type="radio" name="category" id="select_3" class="select_3" value="types">
                        <label for="select_3" class="label_3">Type</label>

                        <input type="radio" name="category" id="select_4" class="select_4" value="ways">
                        <label for="select_4" class="label_4">Way</label>
                    </div>

                    <input name="search" class="Search_Bar" placeholder="Search?" required>
                    <button type="submit" class="Search_button"> Search </button>
                </form>
            </div>

            <div class = "Main_Content_2"> <!-- Shows me analytics or whatever -->
                <div class="medicines_box">
                    <?php 
                        echo '<p class="medicines_header"> Total Medicines </p>';
                        echo  '<p class="total_medicines">' . $total_medicines . '</p>';
                    ?>
                </div>

                <div class="companies_box">
                    <?php 
                        echo '<p class="companies_header"> Total Companies </p>';
                        echo  '<p class="total_companies">' . $total_companies . '</p>';
                    ?>
                </div>

                <div class="types_box">
                    <?php echo '<p class="types_header"> Total Types </p>';
                        echo  '<p class="total_types">' . $total_types . '</p>';
                    ?>
                </div>

                <div class="ways_box">
                    <?php 
                        echo '<p class="ways_header"> Total Ways </p>';
                        echo  '<p class="total_ways">' . $total_ways . '</p>';
                    ?>
                </div>
            </div>
            
            <div class= "Main_Content_With_Banner_1"> 
                <div class="Recent_Medicines_Banner"> Recent Medicines </div>       
                <div class = "Main_Content_3"> <!-- Shows me 5 recent medicines added -->
                    
                    <?php
                        if ($sql_5->num_rows > 0) {
                            while ($row = $sql_5->fetch_assoc()) {
                                echo "<div class='recent_medicines_box'>";
                                    echo '<img src="http://localhost/Trial/Assets/logos/' . $row["logo"] . '" alt="' . $row["way"] . ' logo" class="med-logo" /> <br>';
                                    echo "<b class='recent_med_name'>" . $row["name"]. "</b>";
                                    echo "<p class='recent_med_price'>$" . $row["price"]. "</p>";
                                echo "</div>";
                            }
                        }
                        ?>
                </div>
            </div>

            <div class="Main_Content_With_Banner_2">
                <div class="Recent_Companies_Banner"> Recent Companies </div> 
                <div class = "Main_Content_4"> <!-- Shows me 3 recent companies added -->
                    
                    <?php
                        if ($sql_6->num_rows > 0) {
                            while ($row = $sql_6->fetch_assoc()) {
                                echo "<div class='recent_companies_box'>";
                                    echo "<b class='recent_companies_name'>" . $row["name"] . "</b>";
                                    echo "<p class='med_count'> (" . $row["med_count"] . " medicines)". " </p>";

                                echo "</div>";
                            }
                        }
                        ?>
                </div> 
            </div>
        </div>

    </body>
</html>