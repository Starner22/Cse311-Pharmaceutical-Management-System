<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);


    if (isset ($_GET['sort']))
        $sort = $_GET['sort'];
    else 
        $sort = 'id';
    ///////////////////////////////
    if ($sort === 'w.name_asc')
        $order = 'w.Name ASC';
    elseif ($sort === 'w.name_desc')
        $order = 'w.Name DESC';
    elseif ($sort === 'w.med_count_asc')
        $order = 'med_count ASC';
    elseif ($sort === 'w.med_count_desc')
        $order = 'med_count Desc';
    else
        $order = 'm.medicine_ID ASC';


        $sql = "SELECT w.way_id as ID, w.Name as name, w.logo as logo, COUNT(m.way_id) AS med_count
                From way w
                LEFT JOIN medicine m ON w.way_id = m.way_id 
                GROUP BY w.way_id
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
                    <a href="Admin_Edit_Way_Intermediate.php?sort=w.name_asc" class="<?php echo ($sort === 'w.name_asc') ? 'active' : ''; ?>">Sort A → Z</a>
                    <a href="Admin_Edit_Way_Intermediate.php?sort=w.med_count_asc" class="<?php echo ($sort === 'w.med_count_asc') ? 'active' : ''; ?>">Sort Low Med Count</a>
                </div>
                <div class="sort_by_descending">
                <a href="Admin_Edit_Way_Intermediate.php?sort=w.name_desc" class="<?php echo ($sort === 'w.name_desc') ? 'active' : ''; ?>">Sort Z → A</a>
                    <a href="Admin_Edit_Way_Intermediate.php?sort=w.med_count_desc" class="<?php echo ($sort === 'w.med_count_desc') ? 'active' : ''; ?>">Sort High Med Count</a>
                </div>
                <a href="Admin_Edit_Way_Intermediate.php?sort=w.way_ID" class="reset">Reset</a>
            </div>

            <div>
            <table class ="Display_All_Ways">
                <tr class="Display_Header">
                    <th> ID </th>
                    <th> Logo </th>
                    <th> Name </th>
                    <th> Medicine Count </th>
                    <th> Edit </th>
                    <th> Delete </th>
                </tr>
                <?php 
                    while($row = $result->fetch_assoc()){
                        echo '<tr>';
                        echo '<th>' .$row["ID"]. '</th>';
                        echo '<th> <img src="http://localhost/Trial/Assets/logos/' . $row["logo"] . '" alt="' . $row["name"] . ' logo" class="med-logo" /> </th>';
                        echo '<th>'  .$row["name"]. '</th> <th>' .$row["med_count"]. '</th>';
                        echo '<th> <a href="Admin_Edit_Way.php?id='.$row["ID"]. '"> <button class= "Edit_Button"> Edit </button> </a> </th>';
                        echo '<th> <a href="Admin_Delete_Way.php?id='. $row["ID"]. '"> <button class= "Delete_Button"> Delete </button> </a> </th>';
                       echo '</tr>';
                    }
                ?>
            </table>
        </div>
    </body>            
</html>

