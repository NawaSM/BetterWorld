<?php
session_start();
require_once 'db_connection.php';
require_once 'email_functions.php';

if (!isset($_SESSION['org_id'])) {
    header("Location: org-login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage-applications.php");
    exit();
}

$application_id = $_GET['id'];
$org_id = $_SESSION['org_id'];

// First, verify that this application belongs to an opportunity created by this organization
$stmt = $conn->prepare("SELECT a.id FROM applications a 
                        JOIN opportunities o ON a.opportunity_id = o.id 
                        WHERE a.id = ? AND o.organization_id = ?");
$stmt->bind_param("ii", $application_id, $org_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: manage-applications.php");
    exit();
}

// If verified, update the application status to 'rejected'
$stmt = $conn->prepare("UPDATE applications SET status = 'rejected' WHERE id = ?");
$stmt->bind_param("i", $application_id);

if ($stmt->execute()) {
    // Fetch application details
    $app_stmt = $conn->prepare("SELECT u.name, u.email, o.title FROM applications a 
                                JOIN users u ON a.user_id = u.id 
                                JOIN opportunities o ON a.opportunity_id = o.id 
                                WHERE a.id = ?");
    $app_stmt->bind_param("i", $application_id);
    $app_stmt->execute();
    $app_result = $app_stmt->get_result();
    $application = $app_result->fetch_assoc();

    sendApplicationStatusNotification($application['email'], $application['name'], $application['title'], 'rejected');
    header("Location: manage-applications.php?success=application_rejected");
    exit();
} else {
    header("Location: manage-applications.php?error=rejection_failed");
}

$stmt->close();
$conn->close();
?>