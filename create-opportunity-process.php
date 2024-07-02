<?php
// Process the form submission and insert the opportunity into the database
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$title = $_POST['opportunity-title'];
$description = $_POST['opportunity-description'];
$date = $_POST['opportunity-date'];
$location = $_POST['opportunity-location'];

// Handle image upload
$targetDir = 'uploads/';
$targetFile = $targetDir . basename($_FILES['opportunity-image']['name']);
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
$uploadSuccess = move_uploaded_file($_FILES['opportunity-image']['tmp_name'], $targetFile);

if ($uploadSuccess) {
    $imagePath = $targetFile;
} else {
    $imagePath = '';
}

$sql = "INSERT INTO opportunities (title, description, date, location, image) VALUES ('$title', '$description', '$date', '$location', '$imagePath')";

if ($conn->query($sql) === TRUE) {
    header("Location: opportunities.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>