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
if ($sort === 'c.name_asc')
    $order = 'c.name ASC';
elseif ($sort === 'c.name_desc')
    $order = 'c.name DESC';
else
    $order = 'c.company_id ASC';




$total_result = $conn->query("SELECT COUNT(*) AS total FROM company");
$total_row = $total_result->fetch_assoc();
$total_companies = $total_row['total'];
$total_pages = ceil($total_companies / $limit); //dont floor this

$sql =         "SELECT  c.company_id AS id, c.name AS name, COUNT(m.company_id) AS med_count 
                FROM company c
                LEFT JOIN medicine m ON c.company_id = m.company_id 
                GROUP BY c.company_id
                ORDER BY $order LIMIT $offset, $limit";
$result = $conn->query($sql);
?>

<!-- JOIN doesn't work for companies with no medicines. So, LEFT JOIN it is -->


<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company List</title>
    <link rel="stylesheet" href="http://localhost/Trial/Styles/Company_Database_Styles.css">
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
        <p>Company List</p>
    </div>
    <div class = "Counter">
        <?php echo "<p>(" . $total_companies . " companies found)</p>"; ?>
    </div>
    
    <div class="sort-buttons">
        <a href="Company_Database.php?sort=c.name_asc" class="<?php echo ($sort === 'c.name_asc') ? 'active' : ''; ?>">Sort A → Z</a>
        <a href="Company_Database.php?sort=c.name_desc" class="<?php echo ($sort === 'c.name_desc') ? 'active' : ''; ?>">Sort Z → A</a>
        <a href="Company_Database.php?sort=c.company_id" class="reset">Reset</a>
    </div>

    <div class="container">
        <?php
        if ($result->num_rows > 0) { 
            while ($row = $result->fetch_assoc()) {
                echo "<div class='company-box'>"; 
                    echo "<a href='Medicine-Company_Intermediate.php?id=" . $row["id"] . "' class='company-details'>";

                        echo "<div class='box-header'>";
                            echo "<b class='company-name'>" . $row["name"] . "</b>";
                            echo "<p class='medicine-count'>" . $row["med_count"] . " medicines". " </p>";
                        echo "</div>";

                    echo "</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No companies found</p>";
        }
        ?>
    </div>

    <!-- Reminder for me to anchor the flexboxes to Company_Medicine_Intermediate. Else this .php will be of no use -->
    <!-- couldn't manage to return back to the original url. It's hard. Get wont work. Maybe there's else I can try? But time's short.-->

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="Company_Database.php?page=1&sort=<?php echo $sort ?>">« First</a>
            <a href="Company_Database.php?page=<?php echo $page - 1; ?>&sort=<?php echo $sort; ?>"><</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="Company_Database.php?sort=<?php echo $sort; ?>&page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="Company_Database.php?page=<?php echo $page + 1; ?>&sort=<?php echo $sort; ?>">></a>
            <a href="Company_Database.php?page=<?php echo $total_pages; ?>&sort=<?php echo $sort ?>">Last »</a>
        <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>


<!-- How to 'not' show what stuff I am sorting? Malicious user may inject sql and kill the db. Someone focus on security or smth -->