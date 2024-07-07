<?php
session_start();
require_once __DIR__ . '/env_loader.php';
loadEnv();

// Check if the organization is logged in
if (!isset($_SESSION['org_id'])) {
    header("Location: org-login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "betterworld";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$opportunityId = $_POST['opportunity-id'];
$orgId = $_SESSION['org_id'];
$title = $_POST['opportunity-title'];
$description = $_POST['opportunity-description'];
$date = $_POST['opportunity-date'];
$location = $_POST['opportunity-location'];

// Handle image upload
if (isset($_FILES['opportunity-image']) && $_FILES['opportunity-image']['error'] === UPLOAD_ERR_OK) {
    $image = file_get_contents($_FILES['opportunity-image']['tmp_name']);
} else {
    $image = null;
}

// Update the opportunity in the database
$stmt = $conn->prepare("UPDATE opportunities SET title = ?, description = ?, date = ?, location = ?, image = ? WHERE id = ? AND organization_id = ?");
$stmt->bind_param("sssssii", $title, $description, $date, $location, $image, $opportunityId, $orgId);

if ($stmt->execute()) {
    header("Location: manage-opportunities.php");
    exit();
} else {
    echo "Error updating opportunity: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>