<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Opportunities - BetterWorld</title>
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
                <ul class="menu">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="opportunities.php">Volunteer Opportunities</a></li>
                    <li><a href="profile.html">My Profile</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="login.html">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <section class="opportunities">
            <h1>Volunteer Opportunities</h1>
            <div class="search-bar">
                <input type="text" placeholder="Search opportunities...">
                <button>Search</button>
            </div>
            <div class="opportunity-list">
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
                        echo '<div class="opportunity-card">';
                        echo '<img src="' . $row['image'] . '" alt="' . $row['title'] . '">';
                        echo '<div class="opportunity-card-content">';
                        echo '<h3>' . $row['title'] . '</h3>';
                        echo '<p>' . $row['description'] . '</p>';
                        echo '<a href="opportunity-details.php?id=' . $row['id'] . '" class="btn">Learn More</a>';
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