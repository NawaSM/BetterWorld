<?php
session_start();
require_once 'db_connection.php';
require_once __DIR__ . '/env_loader.php';
loadEnv();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $location = $_POST['location'];

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profile_picture = file_get_contents($_FILES['profile_picture']['tmp_name']);
        
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, location = ?, profile_picture = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $email, $location, $profile_picture, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, location = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $location, $user_id);
    }

    if ($stmt->execute()) {
        header("Location: profile.php?success=1");
    } else {
        header("Location: profile.php?error=1");
    }

    $stmt->close();
} else {
    header("Location: profile.php");
}

$conn->close();
?>