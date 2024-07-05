<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applications - BetterWorld</title>
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
        <section class="manage-applications-section">
            <h1>Manage Volunteer Applications</h1>
            <div class="application-list">
                <!-- Dynamically populate volunteer applications here -->
                <?php
                // Retrieve applications from the database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "betterworld";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM applications";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="application-item">';
                        echo '<h3>Applicant: ' . $row['applicant_name'] . '</h3>';
                        echo '<p>Opportunity: ' . $row['opportunity_title'] . '</p>';
                        echo '<p>Date Applied: ' . $row['date_applied'] . '</p>';
                        echo '<div class="actions">';
                        echo '<a href="view-application.php?id=' . $row['id'] . '" class="btn">View</a>';
                        echo '<a href="approve-application.php?id=' . $row['id'] . '" class="btn">Approve</a>';
                        echo '<a href="reject-application.php?id=' . $row['id'] . '" class="btn">Reject</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No applications found.</p>';
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