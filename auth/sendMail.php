<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function sendVerificationEmail($email, $username, $token)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alaa01007202317@gmail.com';       // إيميلك
        $mail->Password = 'pktd djcc yxwv ytkv';          // App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('alaa01007202317@gmail.com', 'My Note App');
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = 'Verify your email';
        $link = "http://localhost/note_api/auth/verify.php?token=$token";
        $mail->Body = "
            <h2>Hi $username!</h2>
            <p>Click the button below to verify your account:</p>
            <a href='$link' style='display:inline-block;padding:10px 20px;background:#28a745;color:#fff;text-decoration:none;border-radius:5px;'>Verify Email</a>
            <p>If you did not register, ignore this email.</p>
        ";

        $mail->send();
        return "sent";
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return "error: " . $mail->ErrorInfo;
    }
}
