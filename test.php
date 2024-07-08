<?php 
require_once 'email_functions.php';

// Test sending an email
$testEmail = 'nmubukwanu1@gmail.com';
$testName = 'Test User';
$testOpportunity = 'Test Opportunity';

$result = sendApplicationNotification($testEmail, $testName, $testOpportunity);

if ($result) {
    echo "Test email sent successfully!";
} else {
    echo "Failed to send test email.";
}

