<?php
session_start();
require_once 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle search and sort parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

// Prepare base queries for active and past applications
$sql_active = "SELECT o.*, a.status, a.created_at as applied_date 
               FROM opportunities o 
               JOIN applications a ON o.id = a.opportunity_id 
               WHERE a.user_id = ? AND o.date >= CURDATE()";

$sql_past = "SELECT o.*, a.status, a.created_at as applied_date 
             FROM opportunities o 
             JOIN applications a ON o.id = a.opportunity_id 
             WHERE a.user_id = ? AND o.date < CURDATE()";

// Add search condition if search term is provided
if (!empty($search)) {
    $search_condition = " AND (o.title LIKE ? OR o.description LIKE ?)";
    $sql_active .= $search_condition;
    $sql_past .= $search_condition;
}

// Add sorting
$sql_active .= " ORDER BY o.$sort $order";
$sql_past .= " ORDER BY o.$sort $order";

// Prepare and execute queries
$stmt_active = $conn->prepare($sql_active);
$stmt_past = $conn->prepare($sql_past);

if (!empty($search)) {
    $search_term = "%$search%";
    $stmt_active->bind_param("iss", $user_id, $search_term, $search_term);
    $stmt_past->bind_param("iss", $user_id, $search_term, $search_term);
} else {
    $stmt_active->bind_param("i", $user_id);
    $stmt_past->bind_param("i", $user_id);
}

$stmt_active->execute();
$active_applications = $stmt_active->get_result();

$stmt_past->execute();
$past_applications = $stmt_past->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>My Applications</h1>

            <form action="" method="GET" class="search-sort-form">
                <input type="text" name="search" placeholder="Search opportunities" value="<?php echo htmlspecialchars($search); ?>">
                <select name="sort">
                    <option value="date" <?php echo $sort == 'date' ? 'selected' : ''; ?>>Date</option>
                    <option value="title" <?php echo $sort == 'title' ? 'selected' : ''; ?>>Title</option>
                </select>
                <select name="order">
                    <option value="DESC" <?php echo $order == 'DESC' ? 'selected' : ''; ?>>Descending</option>
                    <option value="ASC" <?php echo $order == 'ASC' ? 'selected' : ''; ?>>Ascending</option>
                </select>
                <button type="submit">Apply</button>
            </form>

            <section class="active-applications">
                <h2>Active Applications</h2>
                <?php displayApplications($active_applications); ?>
            </section>

            <section class="past-applications">
                <h2>Past Applications</h2>
                <?php displayApplications($past_applications); ?>
            </section>
        </main>
    </div>
    <footer>
        <p>&copy; BetterWorld. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>

<?php
function displayApplications($applications) {
    if ($applications->num_rows > 0) {
        echo "<div class='application-list'>";
        while ($app = $applications->fetch_assoc()) {
            echo "<div class='application-card'>";
            echo "<h3>" . htmlspecialchars($app['title']) . "</h3>";
            echo "<p>Date: " . htmlspecialchars($app['date']) . "</p>";
            echo "<p>Status: " . htmlspecialchars($app['status']) . "</p>";
            echo "<p>Applied on: " . htmlspecialchars($app['applied_date']) . "</p>";
            echo "<a href='opportunity-details.php?id=" . $app['id'] . "' class='btn'>View Details</a>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>No applications found.</p>";
    }
}
?>