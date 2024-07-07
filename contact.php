<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>Contact Us</h1>
            <div class="contact-info">
                <p><strong>Email:</strong> contact@betterworld.org</p>
                <p><strong>Phone:</strong> +1 (123) 456-7890</p>
                <p><strong>Address:</strong> 123 Volunteer Street, Charity City, GD 12345</p>
                <p>We're here to help! If you have any questions or concerns, please don't hesitate to reach out to us using the contact information above.</p>
            </div>
        </main>
    </div>

    <div id="toast-container"></div>

    <footer>
        <p>&copy; 2023 BetterWorld. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>