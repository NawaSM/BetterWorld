<?php
session_start();
require_once 'db_connection.php';
require_once 'email_functions.php';
require_once __DIR__ . '/env_loader.php';
loadEnv();

if (!isset($_SESSION['org_id'])) {
    header("Location: org-login.php");
    exit();
}

$org_id = $_SESSION['org_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $opportunity_id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $stmt = $conn->prepare("UPDATE opportunities SET title = ?, description = ?, date = ?, time = ?, location = ?, image = ? WHERE id = ? AND organization_id = ?");
        $stmt->bind_param("ssssssii", $title, $description, $date, $time, $location, $image, $opportunity_id, $org_id);
    } else {
        $stmt = $conn->prepare("UPDATE opportunities SET title = ?, description = ?, date = ?, time = ?, location = ? WHERE id = ? AND organization_id = ?");
        $stmt->bind_param("sssssii", $title, $description, $date, $time, $location, $opportunity_id, $org_id);
    }

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Opportunity updated successfully.";
        header("Location: manage-opportunities.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error updating opportunity: " . $conn->error;
        header("Location: edit-opportunity.php?id=" . $opportunity_id);
        exit();
    }
} else {
    header("Location: manage-opportunities.php");
    exit();
}