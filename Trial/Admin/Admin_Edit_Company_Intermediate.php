<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);


    if (isset ($_GET['sort']))
        $sort = $_GET['sort'];
    else 
        $sort = 'id';
    ///////////////////////////////
    if ($sort === 'c.name_asc')
        $order = 'c.Name ASC';
    elseif ($sort === 'c.name_desc')
        $order = 'c.Name DESC';
    elseif ($sort === 'c.med_count_asc')
        $order = 'med_count ASC';
    elseif ($sort === 'c.med_count_desc')
        $order = 'med_count Desc';
    elseif ($sort === 'c.date_created_asc')
        $order = 'c.date_created ASC';
    elseif ($sort === 'c.date_created_desc')
        $order = 'c.date_created Desc';
    else
        $order = 'c.Company_ID ASC';

        $sql = "SELECT c.Company_Id as ID, c.Name as name, c.HQ_Address as address, c.contact as contact, COUNT(m.company_id) AS med_count, c.date_created as date_created
                From Company c
                LEFT JOIN medicine m ON c.company_id = m.company_id 
                GROUP BY c.company_id
                ORDER BY $order";
        $result = $conn->query($sql);

        
?>


<!DOCTYPE HTML>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Page</title>
        <link rel="stylesheet" href="http://localhost/Trial/Styles/Admin_Edit_Data_Intermediate_Styles.css">
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

        <div class="Main_Content">

            <div class="sort_buttons">
                <div class="sort_by_ascending">
                    <a href="Admin_Edit_Company_Intermediate.php?sort=c.name_asc" class="<?php echo ($sort === 'c.name_asc') ? 'active' : ''; ?>">Sort A → Z</a>
                    <a href="Admin_Edit_Company_Intermediate.php?sort=c.date_created_desc" class="<?php echo ($sort === 'c.date_created_desc') ? 'active' : ''; ?>">Sort New</a>
                    <a href="Admin_Edit_Company_Intermediate.php?sort=c.med_count_asc" class="<?php echo ($sort === 'c.med_count_asc') ? 'active' : ''; ?>">Sort Low Med Count</a>
                    <!-- <a href="Admin_Edit_Company_Intermediate.php?sort=c.company_ID_asc" class="<?php echo ($sort === 'c.Company_ID_asc') ? 'active' : ''; ?>">Sort 1 → n</a> -->
                </div>
                <div class="sort_by_descending">
                    <a href="Admin_Edit_Company_Intermediate.php?sort=c.name_desc" class="<?php echo ($sort === 'c.name_desc') ? 'active' : ''; ?>">Sort Z → A</a>
                    <a href="Admin_Edit_Company_Intermediate.php?sort=c.date_created_asc" class="<?php echo ($sort === 'c.date_created_asc') ? 'active' : ''; ?>">Sort Old</a>
                    <a href="Admin_Edit_Company_Intermediate.php?sort=c.med_count_desc" class="<?php echo ($sort === 'c.med_count_desc') ? 'active' : ''; ?>">Sort High Med Count</a>
                    <!-- <a href="Admin_Edit_Company_Intermediate.php?sort=c.company_ID_desc" class="<?php echo ($sort === 'c.Company_ID_desc') ? 'active' : ''; ?>">Sort n → 1</a> -->
                </div> 
                <div class="sort_by_date">
                
                    
                    
                </div>
                <a href="Admin_Edit_Company_Intermediate.php?sort=c.company_ID" class="reset">Reset</a>
            </div>

            <div>
                <table class ="Display_All_Companies">
                    <tr class="Display_Header">
                        <th> ID </th>
                        <th> Name </th>
                        <th> Address </th>
                        <th> Contact </th>
                        <th> Medicine Count </th>
                        <th> Date Created </th>
                        <th> Edit </th>
                        <th> Delete </th>

                    </tr>
                        <?php 
                            while($row = $result->fetch_assoc()){
                                echo '<tr>';
                                echo '<th>' .$row["ID"]. '</th>';
                                echo '<th>'  .$row["name"]. '</th> <th>' .$row["address"]. '</th> <th>' .$row["contact"]. '</th> <th>' .$row["med_count"]. '</th> <th>' .$row["date_created"]. '</th>';
                                echo '<th> <a href="Admin_Edit_Company.php?id='.$row["ID"]. '"> <button class= "Edit_Button"> Edit </button> </a> </th>';
                                echo '<th> <a href="Admin_Delete_Company.php?id='. $row["ID"]. '"> <button class= "Delete_Button"> Delete </button> </a> </th>';
                                echo '</tr>';
                            }
                        ?>
                    </table>
            </div>   
        </div>
    </body>
</html>

