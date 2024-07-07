<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['org_id']) || !isset($_GET['id'])) {
    header("Location: manage-applications.php");
    exit();
}

$application_id = $_GET['id'];
$org_id = $_SESSION['org_id'];

$stmt = $conn->prepare("SELECT a.*, u.name as applicant_name, u.email as applicant_email, o.title as opportunity_title
                        FROM applications a 
                        JOIN users u ON a.user_id = u.id
                        JOIN opportunities o ON a.opportunity_id = o.id
                        WHERE a.id = ? AND o.organization_id = ?");
$stmt->bind_param("ii", $application_id, $org_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: manage-applications.php");
    exit();
}

$application = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Application - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'org-nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>Application Details</h1>
            
            <div class="application-details">
                <h2><?php echo htmlspecialchars($application['opportunity_title']); ?></h2>
                <p><strong>Applicant Name:</strong> <?php echo htmlspecialchars($application['applicant_name']); ?></p>
                <p><strong>Applicant Email:</strong> <?php echo htmlspecialchars($application['applicant_email']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($application['status']); ?></p>
                <p><strong>Applied on:</strong> <?php echo $application['created_at']; ?></p>
                
                <h3>Motivation:</h3>
                <div class="motivation-text">
                    <?php echo nl2br(htmlspecialchars($application['motivation'])); ?>
                </div>
                
                <?php if ($application['status'] == 'pending'): ?>
                    <div class="application-actions">
                        <a href="approve-application.php?id=<?php echo $application['id']; ?>" class="btn btn-success">Approve</a>
                        <a href="reject-application.php?id=<?php echo $application['id']; ?>" class="btn btn-danger">Reject</a>
                    </div>
                <?php endif; ?>
                
                <a href="manage-applications.php" class="btn btn-secondary">Back to Applications</a>
            </div>
        </main>
    </div>

    <footer>
        <p>&copy; 2023 BetterWorld. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>