<?php
session_start();
require_once 'db_connection.php';

if (isset($_SESSION['org_id'])) {
    $org_id = $_SESSION['org_id'];
    $stmt = $conn->prepare("SELECT logo FROM organizations WHERE id = ?");
    $stmt->bind_param("i", $org_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $org = $result->fetch_assoc();

    if ($org && $org['logo']) {
        // Detect the image type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $image_type = $finfo->buffer($org['logo']);

        // Set the appropriate Content-Type header
        header("Content-Type: $image_type");
        
        // Prevent caching
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        
        // Output the image data
        echo $org['logo'];
    } else {
        // If no logo is found, serve a default image
        $default_image = file_get_contents('default-org-logo.jpg');
        header("Content-Type: image/jpeg");
        echo $default_image;
    }
} else {
    // If the organization is not logged in, serve a default image
    $default_image = file_get_contents('default-org-logo.jpg');
    header("Content-Type: image/jpeg");
    echo $default_image;
}

exit();