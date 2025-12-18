<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);


    if (isset ($_GET['sort']))
        $sort = $_GET['sort'];
    else 
        $sort = 'id';
    ///////////////////////////////
    if ($sort === 't.Name_asc')
        $order = 't.Name ASC';
    elseif ($sort === 't.Name_desc')
        $order = 't.Name DESC';
    elseif ($sort === 't.med_count_asc')
        $order = 'med_count ASC';
    elseif ($sort === 't.med_count_desc')
        $order = 'med_count Desc';
    else
        $order = 't.Type_ID ASC';


        $sql = "SELECT t.Type_ID as ID, t.Name as name, COUNT(m.Type_ID) AS med_count
                From types t
                LEFT JOIN medicine m ON t.Type_ID = m.Type_ID 
                GROUP BY t.Type_ID
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
                    <a href="Admin_Edit_Type_Intermediate.php?sort=t.Name_asc" class="<?php echo ($sort === 't.Name_asc') ? 'active' : ''; ?>">Sort A → Z</a>
                    <a href="Admin_Edit_Type_Intermediate.php?sort=t.med_count_asc" class="<?php echo ($sort === 't.med_count_asc') ? 'active' : ''; ?>">Sort Low Med Count</a>
                </div>
                <div class="sort_by_descending">
                <a href="Admin_Edit_Type_Intermediate.php?sort=t.Name_desc" class="<?php echo ($sort === 't.Name_desc') ? 'active' : ''; ?>">Sort Z → A</a>
                    <a href="Admin_Edit_Type_Intermediate.php?sort=t.med_count_desc" class="<?php echo ($sort === 't.med_count_desc') ? 'active' : ''; ?>">Sort High Med Count</a>
                </div>
                <a href="Admin_Edit_Type_Intermediate.php?sort=t.type_ID" class="reset">Reset</a>
            </div>

            <div>
            <table class ="Display_All_Types">
                <tr class="Display_Header">
                    <th> ID </th>
                    <th> Name </th>
                    <th> Medicine Count </th>
                    <th> Edit </th>
                    <th> Delete </th>
                </tr>
                <?php 
                    while($row = $result->fetch_assoc()){
                        echo '<tr>';
                        echo '<th>' .$row["ID"]. '</th>';
                        echo '<th>'  .$row["name"]. '</th> <th>' .$row["med_count"]. '</th>';
                        echo '<th> <a href="Admin_Edit_Type.php?id='.$row["ID"]. '"> <button class= "Edit_Button"> Edit </button> </a> </th>';
                        echo '<th> <a href="Admin_Delete_Type.php?id='. $row["ID"]. '"> <button class= "Delete_Button"> Delete </button> </a> </th>';
                        echo '</tr>';
                    }
                ?>
            </table>
        </div>
    </body>
</html>
                

