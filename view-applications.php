<?php
session_start();
require_once 'db_connection.php';
require_once __DIR__ . '/env_loader.php';

if (!isset($_SESSION['org_id']) || !isset($_GET['id'])) {
    header("Location: manage-opportunities.php");
    exit();
}

$opportunity_id = $_GET['id'];
$org_id = $_SESSION['org_id'];

// First, verify that this opportunity belongs to the logged-in organization
$stmt = $conn->prepare("SELECT title FROM opportunities WHERE id = ? AND organization_id = ?");
$stmt->bind_param("ii", $opportunity_id, $org_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: manage-opportunities.php");
    exit();
}

$opportunity = $result->fetch_assoc();

// Now, fetch the applications for this opportunity
$stmt = $conn->prepare("SELECT a.*, u.name, u.email FROM applications a 
                        JOIN users u ON a.user_id = u.id 
                        WHERE a.opportunity_id = ?");
$stmt->bind_param("i", $opportunity_id);
$stmt->execute();
$applications = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applications - <?php echo htmlspecialchars($opportunity['title']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'org-nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>Applications for: <?php echo htmlspecialchars($opportunity['title']); ?></h1>
            
            <?php if ($applications->num_rows > 0): ?>
                <div class="application-list">
                    <?php while ($app = $applications->fetch_assoc()): ?>
                        <div class="application-card">
                            <h3><?php echo htmlspecialchars($app['name']); ?></h3>
                            <p>Email: <?php echo htmlspecialchars($app['email']); ?></p>
                            <p>Status: <?php echo htmlspecialchars($app['status']); ?></p>
                            <p>Applied on: <?php echo htmlspecialchars($app['created_at']); ?></p>
                            <a href="view-application.php?id=<?php echo $app['id']; ?>" class="btn">View Details</a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No applications found for this opportunity.</p>
            <?php endif; ?>
            
            <a href="manage-opportunities.php" class="btn">Back to Manage Opportunities</a>
        </main>
    </div>

    <footer>
        <p>&copy; 2023 BetterWorld. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>