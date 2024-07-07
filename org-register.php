<?php
session_start();
if (isset($_SESSION['org_id'])) {
    header("Location: org-profile.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Organization - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>Register Organization</h1>
            <form id="org-register-form" action="process-org-register.php" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="name">Organization Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <div>
                    <label for="description">Organization Description:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div>
                    <label for="logo">Organization Logo:</label>
                    <input type="file" id="logo" name="logo" accept="image/*">
                </div>
                <button type="submit" class="btn">Register Organization</button>
            </form>
            <p>Already have an organization account? <a href="org-login.php">Login here</a></p>
            <p>Are you a volunteer? <a href="register.php">Register as a volunteer</a></p>
        </main>
    </div>

    <footer>
        <p>&copy; 2023 BetterWorld. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>