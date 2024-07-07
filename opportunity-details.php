<?php
session_start();
require_once 'db_connection.php';

if (!isset($_GET['id'])) {
    header("Location: opportunities.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT o.*, org.name as org_name, org.email as org_email 
                        FROM opportunities o 
                        JOIN organizations org ON o.organization_id = org.id 
                        WHERE o.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$opportunity = $result->fetch_assoc();

if (!$opportunity) {
    header("Location: opportunities.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($opportunity['title']); ?> - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <div class="opportunity-details">
                <h1><?php echo htmlspecialchars($opportunity['title']); ?></h1>
                
                <?php if ($opportunity['image']): ?>
                    <img src="<?php echo htmlspecialchars($opportunity['image']); ?>" alt="<?php echo htmlspecialchars($opportunity['title']); ?>" class="opportunity-image">
                <?php endif; ?>
                
                <div class="opportunity-info">
                    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($opportunity['description'])); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($opportunity['date']); ?></p>
                    <p><strong>Time:</strong> <?php echo htmlspecialchars($opportunity['time']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($opportunity['location']); ?></p>
                </div>
                
                <div class="organization-info">
                    <h2>Posted by:</h2>
                    <p><strong>Organization:</strong> <?php echo htmlspecialchars($opportunity['org_name']); ?></p>
                    <p><strong>Contact Email:</strong> <?php echo htmlspecialchars($opportunity['org_email']); ?></p>
                </div>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="apply-opportunity.php?id=<?php echo $opportunity['id']; ?>" class="btn btn-primary">Apply Now</a>
                <?php else: ?>
                    <p>Please <a href="login.php">log in</a> to apply for this opportunity.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <footer>
        <p>&copy; 2023 BetterWorld. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>