<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);


    if (isset ($_GET['sort']))
        $sort = $_GET['sort'];
    else 
        $sort = 'id';
    ///////////////////////////////
    if ($sort === 'm.name_asc')
        $order = 'm.Name ASC';
    elseif ($sort === 'm.name_desc')
        $order = 'm.Name DESC';
    elseif ($sort === 'm.price_asc')
        $order = 'm.price ASC'; 
    elseif ($sort === 'm.price_desc')
        $order = 'm.price DESC';
    elseif ($sort === 'm.date_created_asc')
        $order = 'm.date_created ASC';
    elseif ($sort === 'm.date_created_desc')
        $order = 'm.date_created Desc';
    else
        $order = 'm.medicine_ID ASC';


        $sql = "SELECT m.medicine_ID as ID, m.name AS name, m.dosage_value as dosage, m.price as price, m.date_created AS date_created, c.Name as company, w.Name as way, w.logo as logo, t.Name as type
                FROM medicine m
                JOIN company c ON m.company_id = c.company_id
                JOIN way w ON m.way_id = w.way_id
                JOIN types t ON m.type_id = t.type_id
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
                    <a href="Admin_Edit_Medicine_Intermediate.php?sort=m.name_asc" class="<?php echo ($sort === 'm.name_asc') ? 'active' : ''; ?>">Sort A → Z</a>
                    <a href="Admin_Edit_Medicine_Intermediate.php?sort=m.price_asc" class="<?php echo ($sort === 'm.price_asc') ? 'active' : ''; ?>">Sort $ → $$$</a>
                    <a href="Admin_Edit_Medicine_Intermediate.php?sort=m.date_created_asc" class="<?php echo ($sort === 'm.date_created_asc') ? 'active' : ''; ?>">Sort Old</a>
                    <!-- <a href="Admin_Edit_Medicine_Intermediate.php?sort=m.medicine_ID_asc" class="<?php echo ($sort === 'm.medicine_ID_asc') ? 'active' : ''; ?>">Sort 1 → n</a> -->    
                </div>
                <div class="sort_by_descending">
                    <a href="Admin_Edit_Medicine_Intermediate.php?sort=m.name_desc" class="<?php echo ($sort === 'm.name_desc') ? 'active' : ''; ?>">Sort Z → A</a>
                    <a href="Admin_Edit_Medicine_Intermediate.php?sort=m.price_desc" class="<?php echo ($sort === 'm.price_desc') ? 'active' : ''; ?>">Sort $$$ → $</a>
                    <a href="Admin_Edit_Medicine_Intermediate.php?sort=m.date_created_desc" class="<?php echo ($sort === 'm.date_created_desc') ? 'active' : ''; ?>">Sort New</a>
                    <!-- <a href="Admin_Edit_Medicine_Intermediate.php?sort=m.medicine_ID_desc" class="<?php echo ($sort === 'm.medicine_ID_desc') ? 'active' : ''; ?>">Sort n → 1</a> -->
                </div>
                <div class="reset_sort">
                    <a href="Admin_Edit_Medicine_Intermediate.php?sort=m.medicine_ID" class="reset">Reset</a>
                </div>
            </div>

            <div>
            <table class ="Display_All_Medicines">
                <tr class="Display_Header">
                    <th> ID </th>
                    <th> Logo </th>
                    <th> Name </th>
                    <th> Company </th>
                    <th> Dosage </th>
                    <th> Price </th>
                    <th> Type </th>
                    <th> Date Created </th>
                    <th> Edit </th>
                    <th> Delete </th>
                </tr>
                    <?php 
                        while($row = $result->fetch_assoc()){
                            echo '<tr>';
                            echo '<th>' .$row["ID"]. '</th>';
                            echo '<th> <img src="http://localhost/Trial/Assets/logos/' . $row["logo"] . '" alt="' . $row["way"] . ' logo" class="med-logo" /> </th>';
                            echo '<th>'  .$row["name"]. '</th> <th>' .$row["company"]. '</th> <th>' .$row["dosage"]. '</th> <th>' .$row["price"]. '</th> <th>' .$row["type"]. '</th> <th>' .$row["date_created"]. '</th>';
                            echo '<th> <a href="Admin_Edit_Medicine.php?id='.$row["ID"]. '"> <button class= "Edit_Button"> Edit </button> </a> </th>';
                            echo '<th> <a href="Admin_Delete_Medicine.php?id='. $row["ID"]. '"> <button class= "Delete_Button"> Delete </button> </a> </th>';
                            echo '</tr>';
                        }
                    ?>
        </div>
    </body>
</html> 
