<?php
require_once __DIR__ . '/env_loader.php';
require_once(__DIR__ . '/vendor/autoload.php');
loadEnv();

use Brevo\Client\Configuration;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;

function sendEmail($to, $subject, $content) {
    $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', getenv('SENDINBLUE_API_KEY'));

    $apiInstance = new TransactionalEmailsApi(
        new Client(),
        $config
    );

    $sendSmtpEmail = new SendSmtpEmail([
        'subject' => $subject,
        'sender' => ['name' => 'BetterWorld', 'email' => 'p23014801@student.newinti.edu.my'],
        'to' => [['email' => $to]],
        'htmlContent' => $content,
    ]);

    try {
        $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
        return true;
    } catch (Exception $e) {
        error_log('Exception when calling TransactionalEmailsApi->sendTransacEmail: '. $e->getMessage());
        return false;
    }
}

function sendRegistrationNotification($email, $name, $isOrg = false) {
    $subject = "Welcome to BetterWorld - Your Journey Begins Here!";
    $content = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #3498db; color: #ffffff; padding: 20px; text-align: center; }
            .content { background-color: #f8f9fa; padding: 20px; }
            .footer { background-color: #34495e; color: #ffffff; text-align: center; padding: 10px; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Welcome to BetterWorld!</h1>
            </div>
            <div class='content'>
                <h2>Hello " . htmlspecialchars($name) . ",</h2>
                <p>Welcome to BetterWorld! We're thrilled to have you join our community of change-makers.</p>
                <p>Your " . ($isOrg ? "organization" : "volunteer") . " account has been successfully registered.</p>
                <p>At BetterWorld, we believe in the power of volunteering to create positive change. " . 
                ($isOrg ? "Your organization will play a crucial role in providing meaningful opportunities to our volunteers." 
                        : "You're now part of a network of passionate individuals ready to make a difference.") . "</p>
                <p>Next steps:</p>
                <ul>
                    " . ($isOrg ? "<li>Create your first volunteer opportunity</li>
                                   <li>Complete your organization profile</li>"
                               : "<li>Browse available volunteer opportunities</li>
                                  <li>Complete your volunteer profile</li>") . "
                    <li>Connect with " . ($isOrg ? "potential volunteers" : "organizations") . "</li>
                </ul>
                <p>If you have any questions, don't hesitate to reach out to our support team.</p>
                <p>Thank you for choosing to make a difference with BetterWorld!</p>
            </div>
            <div class='footer'>
                <p>&copy; 2023 BetterWorld. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    return sendEmail($email, $subject, $content);
}

function sendApplicationNotification($email, $name, $opportunityTitle) {
    $subject = "Application Submitted Successfully - $opportunityTitle";
    $content = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #2ecc71; color: #ffffff; padding: 20px; text-align: center; }
            .content { background-color: #f8f9fa; padding: 20px; }
            .footer { background-color: #34495e; color: #ffffff; text-align: center; padding: 10px; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Application Submitted!</h1>
            </div>
            <div class='content'>
                <h2>Hello " . htmlspecialchars($name) . ",</h2>
                <p>Great news! Your application for the volunteer opportunity <strong>'" . htmlspecialchars($opportunityTitle) . "'</strong> has been successfully submitted.</p>
                <p>Here's what happens next:</p>
                <ol>
                    <li>The organization will review your application.</li>
                    <li>You'll receive another email when they make a decision.</li>
                    <li>If approved, the organization will provide further details about the opportunity.</li>
                </ol>
                <p>While you wait, why not explore other volunteer opportunities? There's always more ways to make a difference!</p>
                <p>Thank you for your commitment to positive change. Your enthusiasm drives the BetterWorld community!</p>
            </div>
            <div class='footer'>
                <p>&copy; 2023 BetterWorld. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    return sendEmail($email, $subject, $content);
}

function sendApplicationStatusNotification($email, $name, $opportunityTitle, $status) {
    $subject = "Application Update - $opportunityTitle";
    $statusColor = $status === 'approved' ? '#2ecc71' : '#e74c3c';
    $content = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: $statusColor; color: #ffffff; padding: 20px; text-align: center; }
            .content { background-color: #f8f9fa; padding: 20px; }
            .footer { background-color: #34495e; color: #ffffff; text-align: center; padding: 10px; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Application " . ucfirst($status) . "</h1>
            </div>
            <div class='content'>
                <h2>Hello " . htmlspecialchars($name) . ",</h2>
                <p>We have an update regarding your application for the volunteer opportunity <strong>'" . htmlspecialchars($opportunityTitle) . "'</strong>.</p>
                <p>Your application has been <strong>" . $status . "</strong>.</p>
                " . ($status === 'approved' ? 
                "<p>Congratulations! The organization was impressed by your application and would like you to join their initiative. They will contact you shortly with more details about the next steps.</p>
                <p>Remember to:</p>
                <ul>
                    <li>Respond promptly to any further communications from the organization</li>
                    <li>Review the opportunity details again to ensure you're prepared</li>
                    <li>Reach out if you have any questions or concerns</li>
                </ul>"
                : 
                "<p>We appreciate your interest in this opportunity. While it wasn't a match this time, please don't be discouraged. There are many ways to make a difference in your community.</p>
                <p>We encourage you to:</p>
                <ul>
                    <li>Apply for other opportunities that match your skills and interests</li>
                    <li>Keep your profile updated to improve your chances for future opportunities</li>
                    <li>Reach out if you would like feedback on your application</li>
                </ul>") . "
                <p>Thank you for your commitment to making a positive impact. Your enthusiasm is what drives positive change in our communities!</p>
            </div>
            <div class='footer'>
                <p>&copy; 2023 BetterWorld. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    return sendEmail($email, $subject, $content);
}

function sendNewOpportunityNotification($email, $orgName, $opportunityTitle) {
    $subject = "New Opportunity Created - $opportunityTitle";
    $content = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #3498db; color: #ffffff; padding: 20px; text-align: center; }
            .content { background-color: #f8f9fa; padding: 20px; }
            .footer { background-color: #34495e; color: #ffffff; text-align: center; padding: 10px; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>New Opportunity Created</h1>
            </div>
            <div class='content'>
                <h2>Hello " . htmlspecialchars($orgName) . ",</h2>
                <p>Great news! Your new volunteer opportunity <strong>'" . htmlspecialchars($opportunityTitle) . "'</strong> has been successfully created and is now live on BetterWorld.</p>
                <p>What this means:</p>
                <ul>
                    <li>Your opportunity is now visible to potential volunteers</li>
                    <li>Interested volunteers can apply directly through our platform</li>
                    <li>You'll receive notifications when new applications come in</li>
                </ul>
                <p>Next steps:</p>
                <ol>
                    <li>Review your opportunity details to ensure everything is correct</li>
                    <li>Prepare to review incoming applications</li>
                    <li>Consider promoting your opportunity on your social media channels for wider reach</li>
                </ol>
                <p>Thank you for creating opportunities for volunteers to make a difference. Your initiative plays a crucial role in building a better world!</p>
            </div>
            <div class='footer'>
                <p>&copy; 2023 BetterWorld. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    return sendEmail($email, $subject, $content);
}

function sendNewApplicationNotification($email, $orgName, $opportunityTitle, $applicantName) {
    $subject = "New Application Received - $opportunityTitle";
    $content = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #f39c12; color: #ffffff; padding: 20px; text-align: center; }
            .content { background-color: #f8f9fa; padding: 20px; }
            .footer { background-color: #34495e; color: #ffffff; text-align: center; padding: 10px; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>New Application Received</h1>
            </div>
            <div class='content'>
                <h2>Hello " . htmlspecialchars($orgName) . ",</h2>
                <p>Exciting news! You've received a new application for your volunteer opportunity <strong>'" . htmlspecialchars($opportunityTitle) . "'</strong>.</p>
                <p>Application Details:</p>
                <ul>
                    <li>Applicant: " . htmlspecialchars($applicantName) . "</li>
                    <li>Opportunity: " . htmlspecialchars($opportunityTitle) . "</li>
                    <li>Application Date: " . date('F j, Y') . "</li>
                </ul>
                <p>Next steps:</p>
                <ol>
                    <li>Log in to your BetterWorld account</li>
                    <li>Go to your organization dashboard</li>
                    <li>Review the application in detail</li>
                    <li>Make a decision (approve or reject) based on your requirements</li>
                </ol>
                <p>Remember, timely responses help keep volunteers engaged and excited about your opportunity!</p>
                <p>Thank you for your commitment to creating meaningful volunteer experiences. Your efforts make a real difference in your community!</p>
            </div>
            <div class='footer'>
                <p>&copy; 2023 BetterWorld. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    return sendEmail($email, $subject, $content);
}