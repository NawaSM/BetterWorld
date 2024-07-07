<?php
session_start();
require_once 'db_connection.php';
require_once 'email_functions.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: opportunities.php");
    exit();
}

$opportunity_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch opportunity details
$stmt = $conn->prepare("SELECT * FROM opportunities WHERE id = ?");
$stmt->bind_param("i", $opportunity_id);
$stmt->execute();
$result = $stmt->get_result();
$opportunity = $result->fetch_assoc();
$stmt->close();

if (!$opportunity) {
    header("Location: opportunities.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $motivation = $_POST['motivation'];
    
    // Check if the user has already applied
    $stmt = $conn->prepare("SELECT * FROM applications WHERE user_id = ? AND opportunity_id = ?");
    $stmt->bind_param("ii", $user_id, $opportunity_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        $stmt->close();
        // Insert the application
        $stmt = $conn->prepare("INSERT INTO applications (user_id, opportunity_id, motivation, status) VALUES (?, ?, ?, 'pending')");
        $stmt->bind_param("iis", $user_id, $opportunity_id, $motivation);
        if ($stmt->execute()) {
            // Fetch user details
            $user_stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
            $user_stmt->bind_param("i", $user_id);
            $user_stmt->execute();
            $user_result = $user_stmt->get_result();
            $user = $user_result->fetch_assoc();
            $user_stmt->close();

            // Fetch organization details
            $org_stmt = $conn->prepare("SELECT o.name, o.email FROM organizations o JOIN opportunities op ON o.id = op.organization_id WHERE op.id = ?");
            $org_stmt->bind_param("i", $opportunity_id);
            $org_stmt->execute();
            $org_result = $org_stmt->get_result();
            $org = $org_result->fetch_assoc();
            $org_stmt->close();

            sendApplicationNotification($user['email'], $user['name'], $opportunity['title']);
            sendNewApplicationNotification($org['email'], $org['name'], $opportunity['title'], $user['name']);

            header("Location: my-applications.php?success=1");
            exit();
        } else {
            $error = "An error occurred while submitting your application.";
        }
    } else {
        $error = "You have already applied for this opportunity.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Opportunity - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>Apply for: <?php echo htmlspecialchars($opportunity['title']); ?></h1>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="" method="POST">
                <div>
                    <label for="motivation">Why do you want to volunteer for this opportunity? (Your motivation)</label>
                    <textarea id="motivation" name="motivation" required></textarea>
                </div>
                <button type="submit" class="btn">Submit Application</button>
            </form>
        </main>
    </div>

    <footer>
        <p>&copy; 2023 BetterWorld. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>