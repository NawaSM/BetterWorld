<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Opportunity - BetterWorld</title>
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
        <section class="create-opportunity-section">
            <h1>Create Volunteer Opportunity</h1>
            <form class="create-opportunity-form" action="create-opportunity-process.php" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="opportunity-title">Title:</label>
                    <input type="text" id="opportunity-title" name="opportunity-title" required>
                </div>
                <div>
                    <label for="opportunity-description">Description:</label>
                    <textarea id="opportunity-description" name="opportunity-description" required></textarea>
                </div>
                <div>
                    <label for="opportunity-date">Date:</label>
                    <input type="date" id="opportunity-date" name="opportunity-date" required>
                </div>
                <div>
                    <label for="opportunity-location">Location:</label>
                    <input type="text" id="opportunity-location" name="opportunity-location" required>
                </div>
                <div>
                    <label for="opportunity-image">Image:</label>
                    <input type="file" id="opportunity-image" name="opportunity-image" accept="image/*">
                </div>
                <button type="submit" class="btn">Create Opportunity</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; BetterWorld. All rights reserved.</p>
    </footer>
</body>
</html>