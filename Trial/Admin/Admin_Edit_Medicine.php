<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);

    $med_id = $_GET['id'];

    $types = $conn->query("SELECT Type_ID, Name FROM types");
    $companies = $conn->query("SELECT Company_ID, Name FROM company");
    $ways = $conn->query("SELECT Way_ID, Name FROM way");

    $med = $conn->query("SELECT m1.Name as name_in, c1.name as company_in, t1.name as type_in, w1.name as way_in, 
                        m1.Dosage_Value as dosage_in, m1.Image as image_in, m1.Price as price_in
                        FROM medicine m1 
                        JOIN types t1 ON m1.type_ID = t1.type_id
                        JOIN way w1 ON m1.way_ID = w1.way_id
                        JOIN company c1 ON m1.company_ID = c1.company_id
                        WHERE Medicine_ID = $med_id");
    $med_result = $med->fetch_assoc();
    $details = $conn->query("SELECT md1.Ingredients as ingredients_in, md1.Indication as indication_in, md1.Pharmacology as pharmacology_in, 
                            md1.Dosage_Administration as dosage_administration_in, md1.Interaction as interaction_in
                            FROM medicine_details md1 WHERE Medicine_ID = $med_id");
    $details_result = $details->fetch_assoc();
    $safety = $conn->query("SELECT s1.Contradictions as contradictions_in, s1.Side_effects as side_effects_in, s1.Pregnancy_Lactation as pregnancy_lactation_in, 
                            s1.Precaution as precautions_in, s1.Special_Populations as special_populations_in, s1.Overdose as overdose_in, s1.Storage_Conditions as storage_conditions_in
                            FROM safety s1 WHERE Medicine_ID = $med_id");
    $safety_result = $safety->fetch_assoc();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $price = $_POST['price'];
        $dosage = $_POST['dosage'];
        $type = $_POST['type_id'];
        $company = $_POST['company_id'];
        $way = $_POST['way_id'];
        $image= $_POST['med_image'];

        $ingredients = $_POST['ingredients'];
        $indication = $_POST['indication'];
        $pharmacology = $_POST['pharmacology'];
        $dosage_administration = $_POST['dosage_administration'];
        $interaction = $_POST['interaction'];

        $contradictions = $_POST['contradictions'];
        $side_effects = $_POST['side_effects'];
        $pregnancy_lactation = $_POST['pregnancy_lactation'];
        $precaution = $_POST['precaution'];
        $special_populations = $_POST['special_populations'];
        $overdose = $_POST['overdose'];
        $storage_conditions = $_POST['storage_conditions'];

        $sql = "UPDATE medicine SET Name = '$name', Company_ID = '$company', Type_ID = '$type', Way_ID = '$way',Dosage_Value = '$dosage', Image = '$image', Price = '$price'
                        WHERE Medicine_ID = $med_id";
        $conn->query($sql);

        if ($conn->query($sql)){
            $sql_2 = "UPDATE medicine_details SET Ingredients = '$ingredients', Indication = '$indication', Pharmacology = '$pharmacology',
                        Dosage_Administration = '$dosage_administration',Interaction = '$interaction' 
                        WHERE Medicine_ID = $med_id"; 
            $conn->query($sql_2);

            $sql_3 = "UPDATE safety SET Contradictions = '$contradictions', Side_effects = '$side_effects', Pregnancy_Lactation = '$pregnancy_lactation', Precaution = '$precaution', 
                            Special_Populations = '$special_populations', Overdose = '$overdose', Storage_Conditions = '$storage_conditions' 
                            WHERE Medicine_ID = $med_id";
            $conn->query($sql_3);
            
            echo "<p> Medicine edited </p>";
            Header("Location: http://localhost/Trial/Admin/Admin_Edit_Medicine_Intermediate.php");
        }


        
    }
?>

<!DOCTYPE HTML>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Page</title>
        <link rel="stylesheet" href="http://localhost/Trial/Styles/Admin_Add_Edit_Data_Final_Styles.css">
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


    <form action="Admin_Edit_Medicine.php?id= <?php echo "$med_id"?>" method="POST">
        <div class= "Encapsulate">

            Name: <?php echo '<input  name="name" class="Name_Bar" value="' .$med_result['name_in']. '" required>'; ?>
            <br>

            Price: <?php echo '<input  name="price" class="Price_Bar" value="' .$med_result['price_in']. '" required>'; ?>
            <br>
            
            Dosage: <?php echo '<input  name="dosage" class="Dosage_Bar" value="' .$med_result['dosage_in']. '" required>'; ?>
            <br>

            Type: <select name="type_id" class="Type_Bar" required>
                <?php echo '<option value="">' .$med_result["type_in"] . '</option>'; ?>
                <?php while ($row = $types->fetch_assoc()) {
                    echo "<option value='{$row['Type_ID']}'>{$row['Name']}</option>";
                } ?>
            </select>
            <br>

            Company: <select name="company_id" class="Company_Bar" required>
                <?php echo '<option value="">' .$med_result["company_in"] . '</option>'; ?>
                <?php while ($row = $companies->fetch_assoc()) {
                    echo "<option value='{$row['Company_ID']}'>{$row['Name']}</option>";
                } ?>
            </select>
            <br>

            Way: <select name="way_id" class="Way_Bar" required>
                <?php echo '<option value="">' .$med_result["way_in"] . '</option>'; ?>
                <?php while ($row = $ways->fetch_assoc()) {
                    echo "<option value='{$row['Way_ID']}'>{$row['Name']}</option>";
                } ?>
            </select>
            <br>

            Image: <input type="file" name="med_image" class="Image_Bar" enctype="multipart/form-data">
            <br> 

            Ingredients: <textarea name="ingredients" class="Ingredients_Bar"><?php echo isset($details_result['ingredients_in']) ? $details_result['ingredients_in'] : ''; ?></textarea>
            <br>
            Indication: <textarea name="indication" class="Indication_Bar"><?php echo isset($details_result['indication_in']) ? $details_result['indication_in'] : ''; ?></textarea>
            <br>
            Pharmacology: <textarea name="pharmacology" class="Pharmacology_Bar"><?php echo isset($details_result['pharmacology_in']) ? $details_result['pharmacology_in'] : ''; ?></textarea>
            <br>
            Dosage & Administration: <textarea name="dosage_administration" class="Dosage_Administration_Bar"><?php echo isset($details_result['dosage_administration_in']) ? $details_result['dosage_administration_in'] : ''; ?></textarea>
            <br>
            Interaction: <textarea name="interaction" class="Interaction_Bar"><?php echo isset($details_result['interaction_in']) ? $details_result['interaction_in'] : ''; ?></textarea>
            <br>
            Contradictions: <textarea name="contradictions" class="Contradictions_Bar"><?php echo isset($safety_result['contradictions_in']) ? $safety_result['contradictions_in'] : ''; ?></textarea>
            <br>
            Side Effects: <textarea name="side_effects" class="Side_Effects_Bar"><?php echo isset($safety_result['side_effects_in']) ? $safety_result['side_effects_in'] : ''; ?></textarea>
            <br>
            Pregnancy & Lactation: <textarea name="pregnancy_lactation" class="Pregnancy_Lactation_Bar"><?php echo isset($safety_result['pregnancy_lactation_in']) ? $safety_result['pregnancy_lactation_in'] : ''; ?></textarea>
            <br>
            Precaution: <textarea name="precaution" class="Precaution_Bar"><?php echo isset($safety_result['precaution_in']) ? $safety_result['precaution_in'] : ''; ?></textarea>
            <br>
            Special Populations: <textarea name="special_populations" class="Special_Populations_Bar"><?php echo isset($safety_result['special_populations_in']) ? $safety_result['special_populations_in'] : ''; ?></textarea>
            <br>
            Overdose Effects: <textarea name="overdose" class="Overdose_Bar"><?php echo isset($safety_result['overdose_in']) ? $safety_result['overdose_in'] : ''; ?></textarea>
            <br>
            Storage Conditions: <textarea name="storage_conditions"class="Storage_Conditions_Bar" ><?php echo isset($safety_result['storage_conditions_in']) ? $safety_result['storage_conditions_in'] : ''; ?></textarea>
            <br>

            
            <button type="submit" name="submit_medicine" class="Submit_Button">Edit Medicine</button>
        </div>
    </form>