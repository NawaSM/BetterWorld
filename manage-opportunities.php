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

// Fetch active opportunities
$stmt = $conn->prepare("SELECT * FROM opportunities WHERE organization_id = ? AND status = 'active' ORDER BY date DESC");
$stmt->bind_param("i", $org_id);
$stmt->execute();
$active_opportunities = $stmt->get_result();

// Fetch archived opportunities
$stmt = $conn->prepare("SELECT * FROM opportunities WHERE organization_id = ? AND status = 'archived' ORDER BY date DESC");
$stmt->bind_param("i", $org_id);
$stmt->execute();
$archived_opportunities = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Opportunities - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'org-nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>Manage Opportunities</h1>
            
            <div class="opportunity-actions">
                <a href="create-opportunity.php" class="btn btn-primary">Create New Opportunity</a>
            </div>

            <h2>Active Opportunities</h2>
            <div class="opportunity-list">
                <?php while ($opportunity = $active_opportunities->fetch_assoc()): ?>
                    <div class="opportunity-card">
                        <h3><?php echo htmlspecialchars($opportunity['title']); ?></h3>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($opportunity['date']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($opportunity['location']); ?></p>
                        <div class="opportunity-actions">
                            <a href="edit-opportunity.php?id=<?php echo $opportunity['id']; ?>" class="btn btn-secondary">Edit</a>
                            <a href="view-applications.php?id=<?php echo $opportunity['id']; ?>" class="btn btn-info">View Applications</a>
                            <a href="archive-opportunity.php?id=<?php echo $opportunity['id']; ?>" class="btn btn-warning">Archive</a>
                            <a href="delete-opportunity.php?id=<?php echo $opportunity['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this opportunity?');">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <h2>Archived Opportunities</h2>
            <div class="opportunity-list">
                <?php while ($opportunity = $archived_opportunities->fetch_assoc()): ?>
                    <div class="opportunity-card archived">
                        <h3><?php echo htmlspecialchars($opportunity['title']); ?></h3>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($opportunity['date']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($opportunity['location']); ?></p>
                        <div class="opportunity-actions">
                            <a href="unarchive-opportunity.php?id=<?php echo $opportunity['id']; ?>" class="btn btn-success">Unarchive</a>
                            <a href="delete-opportunity.php?id=<?php echo $opportunity['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this opportunity?');">Delete</a>
                        </div>
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