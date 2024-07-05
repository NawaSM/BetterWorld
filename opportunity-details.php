<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opportunity Details - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <nav>
        <div class="navbar">
            <div class="logo">
                <a href="index.html">BetterWorld</a>
            </div>
            <div class="nav-links">
                <input type="checkbox" id="checkbox_toggle" />
                <label for="checkbox_toggle" class="hamburger">&#9776;</label>
                <ul class="menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="opportunities.php">Volunteer Opportunities</a></li>
                    <li><a href="profile.html">My Profile</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="login.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <section class="opportunity-details">
            <?php
            // Retrieve opportunity details from the database based on the ID
            $servername = "localhost";
            $username = "your_username";
            $password = "your_password";
            $dbname = "your_database";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $opportunityId = $_GET['id'];

            $sql = "SELECT * FROM opportunities WHERE id = $opportunityId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<h1>' . $row['title'] . '</h1>';
                echo '<img src="' . $row['image'] . '" alt="' . $row['title'] . '">';
                echo '<p>' . $row['description'] . '</p>';
                echo '<h2>Details</h2>';
                echo '<ul>';
                echo '<li><strong>Date:</strong> ' . $row['date'] . '</li>';
                echo '<li><strong>Time:</strong> ' . $row['time'] . '</li>';
                echo '<li><strong>Location:</strong> ' . $row['location'] . '</li>';
                echo '</ul>';
                echo '<a href="#" class="btn">Apply Now</a>';
            } else {
                echo '<p>Opportunity not found.</p>';
            }

            $conn->close();
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; BetterWorld</p>
    </footer>
</body>
</html>