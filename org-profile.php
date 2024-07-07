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
$stmt = $conn->prepare("SELECT * FROM organizations WHERE id = ?");
$stmt->bind_param("i", $org_id);
$stmt->execute();
$result = $stmt->get_result();
$org = $result->fetch_assoc();

if (!$org) {
    die("Organization not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Profile - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'org-nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>Organization Profile</h1>
            <div class="profile-info">
                <img src="serve_org_logo.php?v=<?php echo time(); ?>" alt="Organization Logo" class="org-logo standardized-image">
                <h2><?php echo htmlspecialchars($org['name']); ?></h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($org['email']); ?></p>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($org['description'])); ?></p>
                <button id="edit-org-profile-btn" class="btn">Edit Profile</button>
            </div>
        </main>
    </div>

    <div id="edit-org-profile-popup" class="popup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <h2>Edit Organization Profile</h2>
            <form id="edit-org-profile-form" action="process-edit-org-profile.php" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="org-name">Organization Name:</label>
                    <input type="text" id="org-name" name="org-name" value="<?php echo htmlspecialchars($org['name']); ?>" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($org['email']); ?>" required>
                </div>
                <div>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($org['description']); ?></textarea>
                </div>
                <div>
                    <label for="logo">Logo:</label>
                    <input type="file" id="logo" name="logo" accept="image/*">
                    <div id="logo-preview"></div>
                </div>
                <button type="submit" class="btn">Update Profile</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 BetterWorld. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>