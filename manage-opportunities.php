<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Opportunities - BetterWorld</title>
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
        <section class="manage-opportunities-section">
            <h1>Manage Volunteer Opportunities</h1>
            <div class="opportunity-list">
                <!-- Dynamically populate volunteer opportunities here -->
                <?php
                // Retrieve opportunities from the database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "betterworld";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM opportunities";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="opportunity-item">';
                        echo '<h3>' . $row['title'] . '</h3>';
                        echo '<p>Date: ' . $row['date'] . '</p>';
                        echo '<p>Location: ' . $row['location'] . '</p>';
                        echo '<div class="actions">';
                        echo '<a href="edit-opportunity.php?id=' . $row['id'] . '" class="btn">Edit</a>';
                        echo '<a href="delete-opportunity.php?id=' . $row['id'] . '" class="btn">Delete</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No opportunities found.</p>';
                }

                $conn->close();
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; BetterWorld</p>
    </footer>
</body>
</html>