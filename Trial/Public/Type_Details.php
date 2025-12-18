<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "pms_db";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['type_id'])) {
    $type_id = intval($_GET['type_id']);

    $sql = "SELECT t.type_id AS id, t.name AS name, t.details AS details
            FROM types t
            WHERE t.type_id = $type_id";
    


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Type Details</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div class='Type_Details-box'>";
                echo "<b>Name: </b>" . $row["name"] . "<br>";
                echo "<b>Description: </b>" . $row["details"] . "<br>";

                echo "<a href='Medicine-Type_Intermediate.php?id=" . $row["id"] . "' class='Type-To-Medicine-Intermediate'>";
                    echo "<div class='box-header'>";
                        echo "<b class='company-name'>Show Medicines" . "</b>";
                    echo "</div>";
                echo "</a>";
            
            echo "</div>";
        }
    }
}

$conn->close();
?>