<?php

    $conn = new mysqli("localhost", "root", "", "pms_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if( isset($_GET['id'])) 
        $med_id = intval($_GET['id']); 
    else
        $med_id = 0;

    $sql =         "SELECT  m.medicine_id AS id, m.name AS name, m.image AS image, t.name AS type, c.name AS company, w.name AS way, w.logo AS logo, 
                        m.dosage_value AS dose, m.price as price,
                        md.Ingredients as ingredient, md.Indication AS indication, md.Pharmacology as pharmacology, md.dosage_administration AS administration, 
                        md.interaction AS interaction, s.Contradictions as contradiction, s.Side_effects as side_effect, s.Pregnancy_Lactation AS pregnancy, s.precaution AS precaution,
                        s.Special_Populations as special_safety, s.overdose as overdose, s.storage_conditions as storage_condition
                    FROM medicine m
                    JOIN types t ON m.type_id = t.type_id
                    JOIN company c ON m.company_id = c.company_id
                    JOIN Way w ON m.way_id = w.way_id
                    LEFT JOIN medicine_details md ON m.medicine_id = md.medicine_id
                    LEFT JOIN safety s ON m.medicine_id = s.medicine_id
                    WHERE m.medicine_id = $med_id";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine List</title>
    <link rel="stylesheet" href="http://localhost/Trial/Styles/Medicine_Details_Styles.css">
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


    <div class = "Header">
    <p>Medicine Details</p>
    </div>

    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="Primary_Display">';

                    echo '<div class="Name_Header">';
                        echo '<div class="Header_Left">';
                            echo '<img src="http://localhost/Trial/Assets/logos/' . $row["logo"] . '"alt="' . $row["way"] . ' logo" class="med_logo" />';
                            echo "<b class='med_name'>" . $row["name"]. "</b>";
                            echo '<p class="med_way">' . $row["way"]. '</p>';
                        echo '</div>';
                        echo '<img src="http://localhost/Trial/Assets/med_images/' . $row["image"] . '"alt="' . $row["name"] . ' image" class="med_image" />';
                    echo '</div>';
                    
                    echo '<div class="Ingredients_Header">';
                        echo '<p class="med_ingredient">' . $row["ingredient"]. '</p>';
                        echo '<p class="med_dose">' . $row["dose"]. '</p>';
                        echo '<b class="med_company">' . $row["company"]. '</b>';
                    echo '</div>';

                    echo '<div class="Price_Header">';
                        echo '<p class="med_price"> Unit Price: $' . $row["price"]. '</p>';
                    echo '</div>';

                echo '</div>';

                echo '<div class="Indication_Display">';
                    echo '<div class="Indication_Banner"> <p> Indications </p> </div>';
                    echo '<p>' . $row["indication"] . '</p>';
                echo '</div>';

                echo '<div class="Pharmacology_Display">';
                    echo '<div class="Pharmacology_Banner"> <p> Pharmacology </p> </div>';
                    echo '<p>' . $row["pharmacology"] . '</p>';
                echo '</div>';

                echo '<div class="Administration_Display">';
                    echo '<div class="Administration_Banner"> <p> Dosage & Pharmacology </p> </div>';
                    echo '<p>' . $row["administration"] . '</p>';
                echo '</div>';

                echo '<div class="Interaction_Display">';
                    echo '<div class="Interaction_Banner"> <p> Interaction </p> </div>';
                    echo '<p>' . $row["interaction"] . '</p>';
                echo '</div>';

                echo '<div class="Contradiction_Display">';
                    echo '<div class="Contradiction_Banner"> <p> Contradictions </p> </div>';
                    echo '<p>' . $row["contradiction"] . '</p>';
                echo '</div>';

                echo '<div class="Side_Effect_Display">';
                    echo '<div class="Side_Effect_Banner"> <p> Side Effects </p> </div>';
                    echo '<p>' . $row["side_effect"] . '</p>';
                echo '</div>';

                echo '<div class="Pregnancy_Display">';
                    echo '<div class="Pregnancy_Banner"> <p> Pregnancy & Lactation </p> </div>';
                    echo '<p>' . $row["pregnancy"] . '</p>';
                echo '</div>';

                echo '<div class="Precaution_Display">';
                    echo '<div class="Precaution_Banner"> <p> Precautions & Warnings </p> </div>';
                    echo '<p>' . $row["precaution"] . '</p>';
                echo '</div>';

                echo '<div class="Special_Population_Display">';
                    echo '<div class="Special_Population_Banner"> <p> Use in Special Populations </p> </div>';
                    echo '<p>' . $row["special_safety"] . '</p>';
                echo '</div>';

                echo '<div class="Overdose_Display">';
                    echo '<div class="Overdose_Banner"> <p> Overdose Effects </p> </div>';
                    echo '<p>' . $row["overdose"] . '</p>';
                echo '</div>';

                echo '<div class="Storage_Conditions_Display">';
                    echo '<div class="Storage_Conditions_Banner"> <p> Storage Conditions </p> </div>';
                    echo '<p>' . $row["storage_condition"] . '</p>';
                echo '</div>';
                
            }
        }

        ?>
    </div>

</body>
</html>

<?php $conn->close(); ?>