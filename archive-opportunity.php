<?php
session_start();
require_once 'db_connection.php';
require_once __DIR__ . '/env_loader.php';
loadEnv();

if (!isset($_SESSION['org_id']) || !isset($_GET['id'])) {
    header("Location: manage-opportunities.php");
    exit();
}

$opportunity_id = $_GET['id'];

$stmt = $conn->prepare("UPDATE opportunities SET status = 'archived' WHERE id = ? AND organization_id = ?");
$stmt->bind_param("ii", $opportunity_id, $_SESSION['org_id']);
$stmt->execute();

header("Location: manage-opportunities.php");
exit();