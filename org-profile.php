<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Profile - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <nav>
        <div class="navbar">
            <div class="logo">
                <a href="org-home.php">BetterWorld Org Portal</a>
            </div>
            <div class="nav-links">
                <ul class="menu">
                    <li><a href="org-home.php">Home</a></li>
                    <li><a href="create-opportunity.php">Create Opportunity</a></li>
                    <li><a href="manage-opportunities.php">Manage Opportunities</a></li>
                    <li><a href="manage-applications.php">Manage Applications</a></li>
                    <li><a href="org-profile.php">Organization Profile</a></li>
                    <li><a href="org-login.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <section class="org-profile-section">
            <h1>Organization Profile</h1>
            <div class="org-profile-info">
                <img src="org-logo.jpg" alt="Organization Logo">
                <h2>Organization Name</h2>
                <p><strong>Email:</strong> org@example.com</p>
                <p><strong>Description:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="org-profile-edit">
                <h2>Edit Profile</h2>
                <form class="org-profile-form" action="update-org-profile.php" method="POST">
                    <div>
                        <label for="org-name">Organization Name:</label>
                        <input type="text" id="org-name" name="org-name" value="Organization Name" required>
                    </div>
                    <div>
                        <label for="org-email">Email:</label>
                        <input type="email" id="org-email" name="org-email" value="org@example.com" required>
                    </div>
                    <div>
                        <label for="org-description">Description:</label>
                        <textarea id="org-description" name="org-description" required>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</textarea>
                    </div>
                    <button type="submit" class="btn">Save Changes</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; BetterWorld. All rights reserved.</p>
    </footer>
</body>
</html>