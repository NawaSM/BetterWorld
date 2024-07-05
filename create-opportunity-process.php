<?php
session_start();

// Process the form submission and insert the opportunity into the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "betterworld";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

// Get the organization ID from the session
if (isset($_SESSION['org_id'])) {
    $organizationId = $_SESSION['org_id'];

    $stmt = $conn->prepare("INSERT INTO opportunities (title, description, date, location, image, organization_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $title, $description, $date, $location, $image, $organizationId);

    if ($stmt->execute()) {
        header("Location: manage-opportunities.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Organization not logged in.";
}

$conn->close();
?>