<?php
session_start();
require_once 'db_connection.php';
require_once __DIR__ . '/env_loader.php';
loadEnv();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user['profile_picture']) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $image_type = $finfo->buffer($user['profile_picture']);
        header("Content-Type: $image_type");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        echo $user['profile_picture'];
    } else {
        $default_image = file_get_contents('default-profile.jpg');
        header("Content-Type: image/jpeg");
        echo $default_image;
    }
} else {
    $default_image = file_get_contents('default-profile.jpg');
    header("Content-Type: image/jpeg");
    echo $default_image;
}

exit();