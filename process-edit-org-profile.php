<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['org_id'])) {
    header("Location: org-login.php");
    exit();
}

$org_id = $_SESSION['org_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['org-name'];
    $email = $_POST['email'];
    $description = $_POST['description'];

    // Handle logo upload
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $logo = file_get_contents($_FILES['logo']['tmp_name']);

        $stmt = $conn->prepare("UPDATE organizations SET name = ?, email = ?, description = ?, logo = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $email, $description, $logo, $org_id);
    } else {
        $stmt = $conn->prepare("UPDATE organizations SET name = ?, email = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $description, $org_id);
    }

    if ($stmt->execute()) {
        header("Location: org-profile.php?success=1");
    } else {
        header("Location: org-profile.php?error=1");
    }

    $stmt->close();
} else {
    header("Location: org-profile.php");
}

$conn->close();
?>