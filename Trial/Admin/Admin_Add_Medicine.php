<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) 
        die("Connection failed: " . $conn->connect_error);

    $types = $conn->query("SELECT Type_ID, Name FROM types");
    $companies = $conn->query("SELECT Company_ID, Name FROM company");
    $ways = $conn->query("SELECT Way_ID, Name FROM way");

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

        $sql = "INSERT INTO medicine(Name, Company_ID, Type_ID, Way_ID, Dosage_Value, Image, Price) VALUES ('$name', '$company', '$type', '$way', '$dosage', '$image', '$price')";
        $result = $conn->query($sql);

        if ($result){
            $medicine_id = $conn->insert_id;
            $sql_2 =    "INSERT INTO medicine_details(Medicine_ID, Ingredients, Indication, Pharmacology, Dosage_Administration, Interaction) 
                        VALUES ('$medicine_id', '$ingredients', '$indication', '$pharmacology', '$dosage_administration', '$interaction')";
            $conn->query($sql_2);

            $sql_3 =    "INSERT INTO safety(Medicine_ID, Contradictions, Side_effects, Pregnancy_Lactation, Precaution, Special_Populations, Overdose, Storage_Conditions)
                        VALUES ('$medicine_id', '$contradictions', '$side_effects', '$pregnancy_lactation', '$precaution', '$special_populations', '$overdose', '$storage_conditions')";
            $conn->query($sql_3);
            
            echo "<p> Medicine added </p>";
            Header("Location: Admin_Add_data.php");
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


    <form action="Admin_Add_Medicine.php" method="POST">
        <div class= "Encapsulate">

            Name: <input  name="name" class="Name_Bar" placeholder="Medicine Name" required>
            <br>

            Price: <input name="price" class="Price_Bar" placeholder="Price" required>
            <br>
            
            Dosage: <input name="dosage" class="Dosage_Bar" placeholder="Dosage" required>
            <br>

            Type:   <select name="type_id" class="Type_Bar" required>
                        <option value="">Select Type</option>
                        <?php while ($row = $types->fetch_assoc()) {
                            echo "<option value='{$row['Type_ID']}'>{$row['Name']}</option>";
                        } ?>
                    </select>
            <br>

            Company: <select name="company_id" class="Company_Bar" required>
                        <option value="">Select Company</option>
                        <?php while ($row = $companies->fetch_assoc()) {
                            echo "<option value='{$row['Company_ID']}'>{$row['Name']}</option>";
                        } ?>
                    </select>
            <br>

            Way:    <select name="way_id" class="Way_Bar" required>
                        <option value="">Select Way</option>
                        <?php while ($row = $ways->fetch_assoc()) {
                            echo "<option value='{$row['Way_ID']}'>{$row['Name']}</option>";
                        } ?>
                    </select>
            <br>

            Image: <input type="file" name="med_image" class="Image_Bar" enctype="multipart/form-data">
            <br> 

            Ingredients: <textarea name="ingredients" class="Ingredients_Bar" placeholder="Ingredients (Optional)"></textarea>
            <br>
            Indication: <textarea name="indication" class="Indication_Bar" placeholder="Indication (Optional)"></textarea>
            <br>
            Pharmacology: <textarea name="pharmacology" class="Pharmacology_Bar" placeholder="Pharmacology (Optional)"></textarea>
            <br>
            Dosage & Administration: <textarea name="dosage_administration" class="Dosage_Administration_Bar" placeholder="Dosage & Administration (Optional)"></textarea>
            <br>
            Interaction: <textarea name="interaction" class="Interaction_Bar" placeholder="Interaction (Optional)"></textarea>
            <br>
            Contradictions: <textarea name="contradictions" class="Contradictions_Bar" placeholder="Contradictions (Optional)"></textarea>
            <br>
            Side Effects: <textarea name="side_effects" class="Side_Effects_Bar" placeholder="Side Effects (Optional)"></textarea>
            <br>
            Pregnancy & Lactation: <textarea name="pregnancy_lactation" class="Pregnancy_Lactation_Bar" placeholder="Pregnancy & Lactation (Optional)"></textarea>
            <br>
            Precaution: <textarea name="precaution" class="Precaution_Bar" placeholder="Precaution (Optional)"></textarea>
            <br>
            Special Populations: <textarea name="special_populations" class="Special_Populations_Bar" placeholder="Special Populations (Optional)"></textarea>
            <br>
            Overdose Effects: <textarea name="overdose" class="Overdose_Bar" placeholder="Overdose Effects (Optional)"></textarea>
            <br>
            Storage Conditions: <textarea name="storage_conditions" class="Storage_Conditions_Bar" placeholder="Storage Conditions (Optional)"></textarea>
            <br>

            <button type="submit" name="submit_medicine" class="Submit_Button">Add Medicine</button>
        </div>
    </form>