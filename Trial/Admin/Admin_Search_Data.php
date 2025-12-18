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
            $sql_2 = "SELECT c.Company_Id as ID, c.Name as name, c.HQ_Address as address, c.contact as contact, COUNT(m.company_id) AS med_count, c.date_created as date_created
                        From Company c
                        LEFT JOIN medicine m ON c.company_id = m.company_id
                        WHERE c.Name LIKE '%$search%'
                        GROUP BY c.company_id";
            $result_company = $conn->query($sql_2);
        }
        if($category === 'types'){
            $sql_3 = "SELECT t.Type_ID as ID, t.Name as name, COUNT(m.Type_ID) AS med_count
                        From types t
                        LEFT JOIN medicine m ON t.Type_ID = m.Type_ID 
                        WHERE t.Name LIKE '%$search%'
                        GROUP BY t.Type_ID";
            $result_type = $conn->query($sql_3);
        }
        if($category === 'ways'){
            $sql_4 = "SELECT w.way_id as ID, w.Name as name, w.logo as logo, COUNT(m.way_id) AS med_count
                        From way w
                        LEFT JOIN medicine m ON w.way_id = m.way_id
                        WHERE w.Name LIKE '%$search%'
                        GROUP BY w.way_id";
            $result_way = $conn->query($sql_4);
        }
    ?>


<!DOCTYPE html>

    <head>
        <title>Search Results</title>
        <link rel="stylesheet" href="http://localhost/Trial/Styles/Admin_Search_Styles.css">
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


        <div class= "Main_Content">
            <form action="http://localhost/Trial/Admin/Admin_Search_Data.php" method="GET" class="Search_Form">
                <div class="search_select">
                    <input type="radio" name="category" id="select_1" class="select_1" value="medicines" <?php if ($category === 'medicines') echo 'checked'; ?>>
                    <label for="select_1" class="label_1">Medicine</label>

                    <input type="radio" name="category" id="select_2" class="select_2" value="companies" <?php if ($category === 'companies') echo 'checked'; ?>>
                    <label for="select_2" class="label_2">Company</label>

                    <input type="radio" name="category" id="select_3" class="select_3" value="types" <?php if ($category === 'types') echo 'checked'; ?>>
                    <label for="select_3" class="label_3">Type</label>

                    <input type="radio" name="category" id="select_4" class="select_4" value="ways" <?php if ($category === 'ways') echo 'checked'; ?>>
                    <label for="select_4" class="label_4">Way</label>
                </div>

                <input name="search" class="Search_Bar" value="<?php echo $search ?>" required>
                <button type="submit" class="Search_button"> Search </button>
            </form>
    

            <div class ="Search">
                <?php  
                    if($category === 'medicines'){
                        echo '<table class ="Display_All_Medicines">';
                        echo '<tr class="Display_Header"> <th> ID </th> <th> Logo </th> <th> Name </th> <th> Company </th> <th> Dosage </th> <th> Price </th> <th> Type </th> <th> Date Created </th><th> Edit </th> <th> Delete </th> </tr>';
                        while($row = $result_medicine->fetch_assoc()){
                            echo '<tr>';
                            echo '<th>' .$row["ID"]. '</th>';
                            echo '<th> <img src="http://localhost/Trial/Assets/logos/' . $row["logo"] . '" alt="' . $row["way"] . ' logo" class="med-logo" /> </th>';
                            echo '<th>'  .$row["name"]. '</th> <th>' .$row["company"]. '</th> <th>' .$row["dosage"]. '</th> <th>' .$row["price"]. '</th> <th>' .$row["type"]. '</th> <th>' .$row["date_created"]. '</th>';
                            echo '<th> <a href="Admin_Edit_Medicine.php?id='.$row["ID"]. '"> <button class= "Edit_Button"> Edit </button> </a> </th>';
                            echo '<th> <a href="Admin_Delete_Medicine.php?id='. $row["ID"]. '"> <button class= "Delete_Button"> Delete </button> </a> </th>';
                            echo '</tr>';
                        }
                        echo'</table>';
                    }

                    elseif ($category === 'companies'){
                        echo '<table class ="Display_All_Companies">';
                        echo '<tr class="Display_Header"> <th> ID </th> <th> Name </th> <th> Address </th> <th> Contact </th> <th> Medicine Count </th> <th> Date Created </th> <th> Edit </th> <th> Delete </th></tr>';
                        while($row = $result_company->fetch_assoc()){
                            echo '<tr>';
                            echo '<th>' .$row["ID"]. '</th>';
                            echo '<th>'  .$row["name"]. '</th> <th>' .$row["address"]. '</th> <th>' .$row["contact"]. '</th> <th>' .$row["med_count"]. '</th> <th>' .$row["date_created"]. '</th>';
                            echo '<th> <a href="Admin_Edit_Company.php?id='.$row["ID"]. '"> <button class= "Edit_Button"> Edit </button> </a> </th>';
                            echo '<th> <a href="Admin_Delete_Company.php?id='. $row["ID"]. '"> <button class= "Delete_Button"> Delete </button> </a> </th>';
                            echo '</tr>';
                        }
                        echo'</table>';

                    }

                    elseif ($category === 'types') {
                        echo '<table class ="Display_All_Types">';
                        echo '<tr class="Display_Header"> <th> ID </th> <th> Name </th> <th> Medicine Count </th><th> Edit </th> <th> Delete </th> </tr>';
                        while($row = $result_type->fetch_assoc()){
                            echo '<tr>';
                            echo '<th>' .$row["ID"]. '</th>';
                            echo '<th>'  .$row["name"]. '</th> <th>' .$row["med_count"]. '</th>';
                            echo '<th> <a href="Admin_Edit_Type.php?id='.$row["ID"]. '"> <button class= "Edit_Button"> Edit </button> </a> </th>';
                            echo '<th> <a href="Admin_Delete_Type.php?id='. $row["ID"]. '"> <button class= "Delete_Button"> Delete </button> </a> </th>';
                            echo '</tr>';
                        }
                        echo'</table>';
                    }

                    elseif ($category === 'ways'){
                        echo '<table class ="Display_All_Ways">';
                        echo '<tr class="Display_Header"> <th> ID </th> <th> Logo </th> <th> Name </th> <th> Medicine Count </th> <th> Edit </th> <th> Delete </th> </tr>';
                        while($row = $result_way->fetch_assoc()){
                            echo '<tr>';
                            echo '<th>' .$row["ID"]. '</th>';
                            echo '<th> <img src="http://localhost/Trial/Assets/logos/' . $row["logo"] . '" alt="' . $row["name"] . ' logo" class="med-logo" /> </th>';
                            echo '<th>'  .$row["name"]. '</th> <th>' .$row["med_count"]. '</th>';
                            echo '<th> <a href="Admin_Edit_Way.php?id='.$row["ID"]. '"> <button class= "Edit_Button"> Edit </button> </a> </th>';
                            echo '<th> <a href="Admin_Delete_Way.php?id='. $row["ID"]. '"> <button class= "Delete_Button"> Delete </button> </a> </th>';
                            echo '</tr>';
                        }
                        echo'</table>';
                    }
                ?>
            </div>
        </div>
    </body>
</html>

