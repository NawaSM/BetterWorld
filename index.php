<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once 'db_connection.php';
require_once __DIR__ . '/env_loader.php';
loadEnv();

// Fetch featured opportunities
$stmt = $conn->prepare("SELECT * FROM opportunities ORDER BY created_at DESC LIMIT 3");
$stmt->execute();
$featured_opportunities = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BetterWorld - Connect and Volunteer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <section class="hero">
                <h1>Make a Difference with BetterWorld</h1>
                <p>Connect with meaningful volunteer opportunities in your community.</p>
                <a href="opportunities.php" class="btn">Find Opportunities</a>
            </section>

            <section class="featured-opportunities">
                <h2>Featured Opportunities</h2>
                <div class="opportunity-list">
                    <?php while ($opportunity = $featured_opportunities->fetch_assoc()): ?>
                        <div class="opportunity-card">
                            <img src="<?php echo htmlspecialchars($opportunity['image']); ?>" alt="<?php echo htmlspecialchars($opportunity['title']); ?>">
                            <div class="opportunity-card-content">
                                <h3><?php echo htmlspecialchars($opportunity['title']); ?></h3>
                                <p><?php echo htmlspecialchars(substr($opportunity['description'], 0, 100)) . '...'; ?></p>
                                <a href="opportunity-details.php?id=<?php echo $opportunity['id']; ?>" class="btn">Learn More</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section>
        </main>
    </div>

    <footer>
        <p>&copy; 2023 BetterWorld. All rights reserved.</p>
    </footer>
    
    <div id="toast-container"></div>

    <script src="script.js"></script>
</body>
</html>