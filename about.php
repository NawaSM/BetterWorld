<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>About BetterWorld</h1>
            <p>BetterWorld is a platform dedicated to connecting passionate individuals with meaningful volunteer opportunities in their local communities. We believe in the power of volunteering and its ability to create positive change in the world.</p>
            
            <h2>Our Mission</h2>
            <p>Our mission is to make volunteering accessible and rewarding for everyone. We strive to create a world where individuals can easily find and contribute to causes they care about, making a tangible impact on society.</p>
            
            <h2>Our Team</h2>
            <div class="team-members">
                <!-- Add team member information here -->
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