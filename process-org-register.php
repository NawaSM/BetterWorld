<?php
require_once 'email_functions.php';
require_once __DIR__ . '/env_loader.php';
loadEnv();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "betterworld";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$description = $_POST['description'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Handle logo upload
$logo = null;
if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
    $filename = $_FILES["logo"]["name"];
    $filetype = $_FILES["logo"]["type"];
    $filesize = $_FILES["logo"]["size"];

    // Verify file extension
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if(!array_key_exists($ext, $allowed)) {
        die("Error: Please select a valid file format.");
    }

    // Verify file size - 5MB maximum
    $maxsize = 5 * 1024 * 1024;
    if($filesize > $maxsize) {
        die("Error: File size is larger than the allowed limit.");
    }

    // Verify MYME type of the file
    if(in_array($filetype, $allowed)) {
        // Check whether file exists before uploading it
        if(file_exists("uploads/" . $filename)) {
            echo $filename . " is already exists.";
        } else {
            if(move_uploaded_file($_FILES["logo"]["tmp_name"], "uploads/" . $filename)) {
                $logo = "uploads/" . $filename;
            } else {
                echo "File is not uploaded";
            }
        }
    } else {
        echo "Error: There was a problem uploading your file. Please try again.";
    }
}

if ($logo) {
    $stmt = $conn->prepare("INSERT INTO organizations (name, email, password, description, logo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $hashedPassword, $description, $logo);
} else {
    $stmt = $conn->prepare("INSERT INTO organizations (name, email, password, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashedPassword, $description);
}

if ($stmt->execute()) {
    $org_id = $conn->insert_id;
    sendRegistrationNotification($email, $name, true);
    header("Location: org-login.php?registered=1");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>