<?php
session_start();

// Process the login form submission
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "betterworld";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['org-email'];
$password = $_POST['org-password'];

$stmt = $conn->prepare("SELECT * FROM organizations WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['org_id'] = $row['id'];
        header("Location: org-home.php");
        exit();
    } else {
        echo "Invalid email or password.";
    }
} else {
    echo "Invalid email or password.";
}

$stmt->close();
$conn->close();
?>