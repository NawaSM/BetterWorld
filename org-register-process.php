<?php
// Process the organization registration form submission
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "betterworld";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['org-name'];
$email = $_POST['org-email'];
$password = $_POST['org-password'];
$description = $_POST['org-description'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO organizations (name, email, password, description) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $hashedPassword, $description);

if ($stmt->execute()) {
    header("Location: org-login.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>