<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nonprofit Organization Login - BetterWorld</title>
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
        <section class="org-login-section">
            <h1>Nonprofit Organization Login</h1>
            <form class="org-login-form" action="org-login-process.php" method="POST">
                <div>
                    <label for="org-email">Email:</label>
                    <input type="email" id="org-email" name="org-email" required>
                </div>
                <div>
                    <label for="org-password">Password:</label>
                    <input type="password" id="org-password" name="org-password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
            <p>Don't have an account? <a href="org-register.php">Register your organization</a></p>
            <p><a href="login.php">Volunteer Login</a></p>
        </section>
    </main>

    <footer>
        <p>&copy; BetterWorld. All rights reserved.</p>
    </footer>
</body>
</html>