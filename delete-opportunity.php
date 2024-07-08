<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['org_id']) || !isset($_GET['id'])) {
    header("Location: manage-opportunities.php");
    exit();
}

$opportunity_id = $_GET['id'];
$org_id = $_SESSION['org_id'];

// Start a transaction
$conn->begin_transaction();

try {
    // First, delete all applications for this opportunity
    $stmt = $conn->prepare("DELETE FROM applications WHERE opportunity_id = ?");
    $stmt->bind_param("i", $opportunity_id);
    $stmt->execute();
    $stmt->close();

    // Then, delete the opportunity
    $stmt = $conn->prepare("DELETE FROM opportunities WHERE id = ? AND organization_id = ?");
    $stmt->bind_param("ii", $opportunity_id, $org_id);
    $stmt->execute();
    $stmt->close();

    $conn->commit();

    $_SESSION['success_message'] = "Opportunity and related applications deleted successfully.";
} catch (Exception $e) {
    // An error occurred, rollback the transaction
    $conn->rollback();
    $_SESSION['error_message'] = "Error deleting opportunity: " . $e->getMessage();
}

header("Location: manage-opportunities.php");
exit();
?>