<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "pms_db";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$limit = 15;
if (isset ($_GET['page']))
    $page = intval($_GET['page']);
else 
    $page = 1;
$offset = ($page - 1) * $limit;


if (isset ($_GET['sort']))
    $sort = $_GET['sort'];
else 
    $sort = 'id';
///////////////////////////////
if ($sort === 't.name_asc')
    $order = 't.name ASC';
elseif ($sort === 't.name_desc')
    $order = 't.name DESC';
else
    $order = 't.type_id ASC';


$total_result = $conn->query("SELECT COUNT(*) AS total FROM types");
$total_row = $total_result->fetch_assoc();
$total_types = $total_row['total'];
$total_pages = ceil($total_types / $limit); //dont floor this

$sql =         "SELECT  t.type_id AS id, t.name AS name, COUNT(m.type_id) AS med_count
                FROM types t
                LEFT JOIN medicine m ON t.type_id = m.type_id
                GROUP BY t.type_id
                ORDER BY $order LIMIT $offset, $limit";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Types List</title>
    <link rel="stylesheet" href="http://localhost/Trial/Styles/Medicine_Type_Database_Styles.css">
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
    <p>Types List</p>
    </div>
    <div class = "Counter">
        <?php echo "<p>(" . $total_types . " types found)</p>"; ?>
    </div>
    
    <div class="sort-buttons">
    <a href="Medicine_Type_Database.php?sort=t.name_asc" class="<?php echo ($sort === 't.name_asc') ? 'active' : ''; ?>">Sort A → Z</a>
    <a href="Medicine_Type_Database.php?sort=t.name_desc" class="<?php echo ($sort === 't.name_desc') ? 'active' : ''; ?>">Sort Z → A</a>
    <a href="Medicine_Type_Database.php?sort=t.type_id" class="reset">Reset</a>
    </div>

    <div class="Main_container">
        <div class="container_1">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='types-box' onclick='load_Type_Details(" . $row["id"] . ")'>"; 
                        
                            
                                echo "<b class='type-name'>" . $row["name"] . "</b>";
                                echo "<p class='medicine-count'>" . $row["med_count"] . " medicines". " </p>";
                            

                    echo "</div>";
                }
            } else {
                echo "<p>No types found</p>";
            }
            ?>
            
        </div>
        <aside class="container_2" id="medicine-details">
                <p></p>
        </aside>
    </div>

    <script>
        function load_Type_Details(typeId) {
            fetch('Type_Details.php?type_id=' + typeId)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("medicine-details").innerHTML = data;
                })
                
        }   
    </script> 
    



</body>
</html>

<?php $conn->close(); ?>
