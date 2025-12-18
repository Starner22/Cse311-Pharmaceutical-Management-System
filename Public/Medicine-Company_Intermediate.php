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
if (isset ($_GET['page ']))
    $page  = intval($_GET['page ']);
else 
    $page  = 1;
$offset = ($page  - 1) * $limit;


if (isset ($_GET['sort']))
    $sort = $_GET['sort'];
else 
    $sort = 'id';
///////////////////////////////
if ($sort === 'm.name_asc')
    $order = 'm.name ASC';
elseif ($sort === 'm.name_desc')
    $order = 'm.name DESC';
else
    $order = 'm.medicine_id ASC';



if( isset($_GET['id'])) 
    $company_id = intval($_GET['id']); // collecting company id from previous url session
else
    $company_id = 0;

$total_result = $conn->query("SELECT COUNT(*) AS total FROM medicine WHERE company_id = $company_id");
$total_row = $total_result->fetch_assoc();
$total_medicines = $total_row['total'];
$total_pages = ceil($total_medicines / $limit);
$sql =         "SELECT  m.medicine_id AS id, m.name AS name, t.name AS type, c.name AS company, w.name AS way, w.logo AS logo, m.dosage_value AS dose 
                FROM medicine m
                JOIN types t ON m.type_id = t.type_id
                JOIN company c ON m.company_id = c.company_id
                JOIN Way w ON m.way_id = w.way_id
                WHERE m.company_id = $company_id
                GROUP BY m.medicine_id
                ORDER BY $order LIMIT $offset, $limit";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine List</title>
    <link rel="stylesheet" href="http://localhost/Trial/Styles/Medicine_Database_Styles.css">
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
    <p>Medicine List</p>
    </div>
    <div class = "Counter">
        <?php echo "<p>(" . $total_medicines . " medicines found)</p>"; ?>
    </div>
    
    <div class="sort-buttons">
        <a href="Medicine-Company_Intermediate.php?id= <?php echo $company_id ?> &sort=m.name_asc" class="<?php echo ($sort === 'm.name_asc') ? 'active' : ''; ?>">Sort A → Z</a>
        <a href="Medicine-Company_Intermediate.php?id= <?php echo $company_id ?> &sort=m.name_desc" class="<?php echo ($sort === 'm.name_desc') ? 'active' : ''; ?>">Sort Z → A</a>
        <a href="Medicine-Company_Intermediate.php?id= <?php echo $company_id ?> &sort=m.medicine_id" class="reset">Reset</a>
    </div>

    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='medicine-box'>";
                    echo "<a href='Medicine_Details.php?id=" . $row["id"] . "' class='med-details'>";

                        echo "<div class='box-header'>";
                            echo "<div class='box-header-left'>";
                                echo "<img src='http://localhost/Trial/Assets/logos/" . $row["logo"] . "' alt='" . $row["way"] . " logo' class='med-logo' />";
                                echo "<b class='med-name'>" . $row["name"]. "</b>";
                            echo "</div>";
                            // echo "<p class='med-way'>" . $row["way"]. "</p>";
                        echo "</div>";

                        echo "<div class='box-middle'>";
                            echo "<p class='med-dose'>Dose: " . $row["dose"] . "</p>";
                            echo "<p class='med-type'>" .$row["type"] . "</p>";
                        echo "</div>";

                        echo "<b class='med-company'> Company: " .$row["company"] . "</b>";
                        

                    echo "</a>";

                echo "</div>";
            }
        } else {
            echo "<p>No medicines found</p>";
        }
        ?>
    </div>


    <div class="pagination">
        <?php if ($page  > 1): ?>
            <a href="Medicine-Company_Intermediate.php?id= <?php echo $company_id ?> &page=1&sort=<?php echo $sort ?>">« First</a>
            <a href="Medicine-Company_Intermediate.php?id= <?php echo $company_id ?> &page=<?php echo $page  - 1; ?>&sort=<?php echo $sort; ?>"><</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="Medicine-Company_Intermediate.php?id= <?php echo $company_id ?> &sort=<?php echo $sort; ?> &page=<?php echo $i; ?>" class="<?php echo ($i == $page ) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page  < $total_pages): ?>
            <a href="Medicine-Company_Intermediate.php?id= <?php echo $company_id ?> &page=<?php echo $page  + 1; ?>&sort=<?php echo $sort; ?>">></a>
            <a href="Medicine-Company_Intermediate.php?id= <?php echo $company_id ?> &page=<?php echo $total_pages; ?>&sort=<?php echo $sort ?>">Last »</a>
        <?php endif; ?>
    </div>

    <div class="retreat_button">
        <a href="Company_Database.php">Return to Company List</a>
    </div>
        
</body>
</html>

<?php $conn->close(); ?>


<!-- Pagination done + made it responsive to screen size change. -->