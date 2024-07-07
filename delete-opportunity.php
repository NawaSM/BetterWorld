<?php
session_start();
require_once 'db_connection.php';
require_once __DIR__ . '/env_loader.php';
loadEnv();

if (!isset($_SESSION['org_id']) || !isset($_GET['id'])) {
    header("Location: manage-opportunities.php");
    exit();
}

$org_id = $_SESSION['org_id'];
$opportunity_id = $_GET['id'];

// First, check if the opportunity belongs to the logged-in organization
$check_stmt = $conn->prepare("SELECT id FROM opportunities WHERE id = ? AND organization_id = ?");
$check_stmt->bind_param("ii", $opportunity_id, $org_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "You don't have permission to delete this opportunity.";
    header("Location: manage-opportunities.php");
    exit();
}

// If the opportunity belongs to the organization, proceed with deletion
$delete_stmt = $conn->prepare("DELETE FROM opportunities WHERE id = ?");
$delete_stmt->bind_param("i", $opportunity_id);

if ($delete_stmt->execute()) {
    $_SESSION['success'] = "Opportunity deleted successfully.";
} else {
    $_SESSION['error'] = "Error deleting opportunity: " . $conn->error;
}

$check_stmt->close();
$delete_stmt->close();
$conn->close();

header("Location: manage-opportunities.php");
exit();
?>