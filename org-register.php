<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your Organization - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <nav>
        <div class="navbar">
            <div class="logo">
                <a href="index.php">BetterWorld</a>
            </div>
            <div class="nav-links">
                <ul class="menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="opportunities.php">Volunteer Opportunities</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <section class="org-register-section">
            <h1>Register Your Organization</h1>
            <form class="org-register-form" action="org-register-process.php" method="POST">
                <div>
                    <label for="org-name">Organization Name:</label>
                    <input type="text" id="org-name" name="org-name" required>
                </div>
                <div>
                    <label for="org-email">Email:</label>
                    <input type="email" id="org-email" name="org-email" required>
                </div>
                <div>
                    <label for="org-password">Password:</label>
                    <input type="password" id="org-password" name="org-password" required>
                </div>
                <div>
                    <label for="org-confirm-password">Confirm Password:</label>
                    <input type="password" id="org-confirm-password" name="org-confirm-password" required>
                </div>
                <div>
                    <label for="org-description">Organization Description:</label>
                    <textarea id="org-description" name="org-description" required></textarea>
                </div>
                <button type="submit" class="btn">Register Organization</button>
            </form>
            <p>Already have an account? <a href="org-login.php">Login</a></p>
        </section>
    </main>

    <footer>
        <p>&copy; BetterWorld. All rights reserved.</p>
    </footer>
</body>
</html>