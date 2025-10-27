<?php
// Show errors while testing
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Adjust the paths below to match your folder structure
require __DIR__ . '/phpmailer/src/Exception.php';
require __DIR__ . '/phpmailer/src/PHPMailer.php';
require __DIR__ . '/phpmailer/src/SMTP.php';

if (isset($_POST['send'])) {

    // Sanitize inputs
    $fullname = htmlspecialchars($_POST['fullname']);
    $email    = htmlspecialchars($_POST['email']);
    $subject  = htmlspecialchars($_POST['subject']);
    $message  = nl2br(htmlspecialchars($_POST['message']));

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mdmobashir178@gmail.com';        // Your Gmail address
        $mail->Password   = 'okihjgibynztfsbe';                // App password (NOT your Gmail login)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender & recipient
        $mail->setFrom('mdmobashir178@gmail.com', 'Website Contact Form');
        $mail->addAddress('mdmobashir178@gmail.com');          // Where you receive messages
        $mail->addReplyTo($email, $fullname);

        // Mail content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> {$fullname}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ";
        $mail->AltBody = strip_tags($message);

        // Send mail
        $mail->send();
        echo "<h3 style='color:green; text-align:center;'>✅ Message sent successfully!</h3>";

    } catch (Exception $e) {
        echo "<h3 style='color:red; text-align:center;'>❌ Message could not be sent.<br>Error: {$mail->ErrorInfo}</h3>";
    }
}
?>
