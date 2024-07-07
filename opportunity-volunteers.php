<?php
session_start();
require_once 'db_connection.php';
require_once __DIR__ . '/env_loader.php';
loadEnv();

if (!isset($_SESSION['org_id'])) {
    header("Location: org-login.php");
    exit();
}

if (!isset($_GET['opportunity_id'])) {
    header("Location: manage-opportunities.php");
    exit();
}

$opportunity_id = $_GET['opportunity_id'];

// Fetch opportunity details
$stmt = $conn->prepare("SELECT title FROM opportunities WHERE id = ? AND organization_id = ?");
$stmt->bind_param("ii", $opportunity_id, $_SESSION['org_id']);
$stmt->execute();
$result = $stmt->get_result();
$opportunity = $result->fetch_assoc();

if (!$opportunity) {
    header("Location: manage-opportunities.php");
    exit();
}

// Fetch volunteers
$stmt = $conn->prepare("SELECT u.id, u.name, u.email, a.status
                        FROM users u
                        JOIN applications a ON u.id = a.user_id
                        WHERE a.opportunity_id = ?");
$stmt->bind_param("i", $opportunity_id);
$stmt->execute();
$volunteers = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteers for <?php echo htmlspecialchars($opportunity['title']); ?> - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'org-nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>Volunteers for <?php echo htmlspecialchars($opportunity['title']); ?></h1>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($volunteer = $volunteers->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($volunteer['name']); ?></td>
                            <td><?php echo htmlspecialchars($volunteer['email']); ?></td>
                            <td><?php echo htmlspecialchars($volunteer['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>

    <footer>
        <p>&copy; BetterWorld. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>