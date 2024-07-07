<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['org_id']) || !isset($_GET['id'])) {
    header("Location: manage-opportunities.php");
    exit();
}

$opportunity_id = $_GET['id'];
$org_id = $_SESSION['org_id'];

$stmt = $conn->prepare("SELECT * FROM opportunities WHERE id = ? AND organization_id = ?");
$stmt->bind_param("ii", $opportunity_id, $org_id);
$stmt->execute();
$result = $stmt->get_result();
$opportunity = $result->fetch_assoc();

if (!$opportunity) {
    header("Location: manage-opportunities.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Opportunity - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'org-nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>Edit Volunteer Opportunity</h1>
            <form id="edit-opportunity-form" action="process-edit-opportunity.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $opportunity['id']; ?>">
                <div>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($opportunity['title']); ?>" required>
                </div>
                <div>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($opportunity['description']); ?></textarea>
                </div>
                <div>
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" value="<?php echo $opportunity['date']; ?>" required>
                </div>
                <div>
                    <label for="time">Time:</label>
                    <input type="time" id="time" name="time" value="<?php echo $opportunity['time']; ?>" required>
                </div>
                <div>
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($opportunity['location']); ?>" required>
                </div>
                <div>
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <?php if ($opportunity['image']): ?>
                        <img src="<?php echo htmlspecialchars($opportunity['image']); ?>" alt="Current Image" style="max-width: 200px;">
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn">Update Opportunity</button>
            </form>
        </main>
    </div>

    <div id="toast-container"></div>

    <footer>
        <p>&copy; 2023 BetterWorld. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>