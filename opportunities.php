<?php
session_start();
require_once 'db_connection.php';
require_once __DIR__ . '/env_loader.php';
loadEnv();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

$query = "SELECT * FROM opportunities WHERE 1=1";
if (!empty($search)) {
    $query .= " AND (title LIKE ? OR description LIKE ?)";
}
$query .= " ORDER BY $sort $order";

$stmt = $conn->prepare($query);
if (!empty($search)) {
    $search_param = "%$search%";
    $stmt->bind_param("ss", $search_param, $search_param);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Opportunities - BetterWorld</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="content-wrapper">
        <main class="container">
            <h1>Volunteer Opportunities</h1>
            
            <form action="" method="GET" class="search-sort-form">
                <input type="text" name="search" placeholder="Search opportunities" value="<?php echo htmlspecialchars($search); ?>">
                <select name="sort">
                    <option value="date" <?php echo $sort == 'date' ? 'selected' : ''; ?>>Date</option>
                    <option value="title" <?php echo $sort == 'title' ? 'selected' : ''; ?>>Title</option>
                </select>
                <select name="order">
                    <option value="DESC" <?php echo $order == 'DESC' ? 'selected' : ''; ?>>Descending</option>
                    <option value="ASC" <?php echo $order == 'ASC' ? 'selected' : ''; ?>>Ascending</option>
                </select>
                <button type="submit">Apply</button>
            </form>

            <div class="opportunity-list">
                <?php while ($opportunity = $result->fetch_assoc()): ?>
                    <div class="opportunity-card">
                        <?php if ($opportunity['image']): ?>
                            <img src="<?php echo htmlspecialchars($opportunity['image']); ?>" alt="<?php echo htmlspecialchars($opportunity['title']); ?>">
                        <?php endif; ?>
                        <div class="opportunity-card-content">
                            <h3><?php echo htmlspecialchars($opportunity['title']); ?></h3>
                            <p><?php echo htmlspecialchars(substr($opportunity['description'], 0, 100)) . '...'; ?></p>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($opportunity['date']); ?></p>
                            <p><strong>Time:</strong> <?php echo htmlspecialchars($opportunity['time']); ?></p>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($opportunity['location']); ?></p>
                            <a href="opportunity-details.php?id=<?php echo $opportunity['id']; ?>" class="btn">Learn More</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </main>
    </div>

    <footer>
        <p>&copy; 2023 BetterWorld. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>