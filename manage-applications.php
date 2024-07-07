<?php
session_start();
require_once 'db_connection.php';
require_once __DIR__ . '/env_loader.php';
loadEnv();

if (!isset($_SESSION['org_id'])) {
    header("Location: org-login.php");
    exit();
}

$org_id = $_SESSION['org_id'];

// Search and sort parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Prepare the base query
$query = "SELECT a.*, o.title as opportunity_title, u.name as applicant_name 
          FROM applications a 
          JOIN opportunities o ON a.opportunity_id = o.id 
          JOIN users u ON a.user_id = u.id 
          WHERE o.organization_id = ?";

// Add search condition if search term is provided
if (!empty($search)) {
    $query .= " AND (o.title LIKE ? OR u.name LIKE ?)";
}

// Add status filtering
if (!empty($status)) {
    $query .= " AND a.status = ?";
}

// Add sorting
$query .= " ORDER BY $sort $order";

$stmt = $conn->prepare($query);

// Bind parameters
if (!empty($search) && !empty($status)) {
    $search_param = "%$search%";
    $stmt->bind_param("isss", $org_id, $search_param, $search_param, $status);
} elseif (!empty($search)) {
    $search_param = "%$search%";
    $stmt->bind_param("iss", $org_id, $search_param, $search_param);
} elseif (!empty($status)) {
    $stmt->bind_param("is", $org_id, $status);
} else {
    $stmt->bind_param("i", $org_id);
}


$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applications - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'org-nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>Manage Applications</h1>
            
            <form action="" method="GET" class="search-sort-form">
                <input type="text" name="search" placeholder="Search applications" value="<?php echo htmlspecialchars($search); ?>">
                <select name="sort">
                    <option value="created_at" <?php echo $sort == 'created_at' ? 'selected' : ''; ?>>Date Applied</option>
                    <option value="opportunity_title" <?php echo $sort == 'opportunity_title' ? 'selected' : ''; ?>>Opportunity Title</option>
                    <option value="applicant_name" <?php echo $sort == 'applicant_name' ? 'selected' : ''; ?>>Applicant Name</option>
                    <option value="status" <?php echo $sort == 'status' ? 'selected' : ''; ?>>Status</option>
                </select>
                <select name="order">
                    <option value="DESC" <?php echo $order == 'DESC' ? 'selected' : ''; ?>>Descending</option>
                    <option value="ASC" <?php echo $order == 'ASC' ? 'selected' : ''; ?>>Ascending</option>
                </select>
                <select name="status">
                    <option value="">All Statuses</option>
                    <option value="pending" <?php echo $status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="approved" <?php echo $status == 'approved' ? 'selected' : ''; ?>>Approved</option>
                    <option value="rejected" <?php echo $status == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                </select>
                <button type="submit">Apply</button>
            </form>

            <div class="application-list">
                <?php while ($application = $result->fetch_assoc()): ?>
                    <div class="application-card">
                        <h3><?php echo htmlspecialchars($application['opportunity_title']); ?></h3>
                        <p><strong>Applicant:</strong> <?php echo htmlspecialchars($application['applicant_name']); ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars($application['status']); ?></p>
                        <p><strong>Applied on:</strong> <?php echo $application['created_at']; ?></p>
                        <p><strong>Motivation:</strong> <?php echo htmlspecialchars(substr($application['motivation'], 0, 100)) . '...'; ?></p>
                        <a href="view-application.php?id=<?php echo $application['id']; ?>" class="btn">View Details</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </main>
    </div>

    <footer>
        <p>&copy; 2023 BetterWorld. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>