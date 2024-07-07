<?php
session_start();
require_once 'db_connection.php';
require_once 'email_functions.php';

if (!isset($_SESSION['org_id'])) {
    header("Location: org-login.php");
    exit();
}

$org_id = $_SESSION['org_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];

    // Handle image upload
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $target_file;
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error = "File is not an image.";
        }
    }

    if (!isset($error)) {
        $stmt = $conn->prepare("INSERT INTO opportunities (title, description, date, time, location, image, organization_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $title, $description, $date, $time, $location, $image, $org_id);

        if ($stmt->execute()) {
            // Fetch organization details for email notification
            $org_stmt = $conn->prepare("SELECT name, email FROM organizations WHERE id = ?");
            $org_stmt->bind_param("i", $org_id);
            $org_stmt->execute();
            $org_result = $org_stmt->get_result();
            $org = $org_result->fetch_assoc();
            $org_stmt->close();

            // Send email notification
            sendNewOpportunityNotification($org['email'], $org['name'], $title);

            header("Location: manage-opportunities.php?success=1");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();

// If there's an error, redirect back to the create opportunity page with the error message
if (isset($error)) {
    $_SESSION['error'] = $error;
    header("Location: create-opportunity.php");
    exit();
}
?>