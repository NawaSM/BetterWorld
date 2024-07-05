<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BetterWorld</title>
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
        <section class="login-section">
            <h1>Login</h1>
            <form class="login-form" action="login-process.php" method="POST">
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register</a></p>
            <p><a href="org-login.php">Nonprofit Organization Login</a></p>
        </section>
    </main>

    <footer>
        <p>&copy; BetterWorld. All rights reserved.</p>
    </footer>
</body>
</html>