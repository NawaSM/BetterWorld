<?php
session_start();
require_once __DIR__ . '/env_loader.php';
loadEnv();

// Check if the organization is logged in
if (!isset($_SESSION['org_id'])) {
    header("Location: org-login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "betterworld";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$orgId = $_SESSION['org_id'];

// Retrieve organization's active opportunities count
$stmt = $conn->prepare("SELECT COUNT(*) AS active_count FROM opportunities WHERE organization_id = ?");
$stmt->bind_param("i", $orgId);
$stmt->execute();
$activeResult = $stmt->get_result();
$activeCount = $activeResult->fetch_assoc()['active_count'];

// Retrieve organization's pending applications count
$stmt = $conn->prepare("SELECT COUNT(*) AS pending_count FROM applications 
                        WHERE opportunity_id IN (SELECT id FROM opportunities WHERE organization_id = ?)
                        AND status = 'pending'");
$stmt->bind_param("i", $orgId);
$stmt->execute();
$pendingResult = $stmt->get_result();
$pendingCount = $pendingResult->fetch_assoc()['pending_count'];

// Retrieve organization's total volunteers count
$stmt = $conn->prepare("SELECT COUNT(DISTINCT user_id) AS total_volunteers 
                        FROM applications 
                        WHERE opportunity_id IN (SELECT id FROM opportunities WHERE organization_id = ?)
                        AND (status = 'approved' OR status = 'pending')");
$stmt->bind_param("i", $org_id);
$stmt->execute();
$totalResult = $stmt->get_result();
$totalVolunteers = $totalResult->fetch_assoc()['total_volunteers'];

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Portal - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'org-nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>Welcome to the Organization Portal</h1>
            <div class="org-dashboard">
                <div class="dashboard-item">
                    <h2>Active Opportunities</h2>
                    <p><?php echo $activeCount; ?></p>
                </div>
                <div class="dashboard-item">
                    <h2>Pending Applications</h2>
                    <p><?php echo $pendingCount; ?></p>
                </div>
                <div class="dashboard-item">
                    <h2>Total Volunteers</h2>
                    <p><?php echo $totalVolunteers; ?></p>
                </div>
            </div>
            <a href="create-opportunity.php" class="btn">Create New Opportunity</a>
        </main>
    </div>

    <footer>
        <p>&copy; BetterWorld. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>