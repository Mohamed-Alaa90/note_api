<?php

include __DIR__ . "/../connectDB.php";
include __DIR__ . "/../functions.php";
include __DIR__ . '/sendMail.php';
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header("Content-Type: application/json; charset=utf-8");

try {
    $username = filterRequest("username");
    $email = filterRequest("email");
    $raw = getJsonInput();
    $password = isset($raw['password']) ? trim($raw['password']) : null;

    $errors = [];
    if (empty($username))
        $errors[] = "username is required";
    if (empty($email)) {
        $errors[] = "email is required";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    } else {
        $email = strtolower($email);
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    if (!empty($errors)) {
        http_response_code(400);
        responseJson(
            "failed",
            "Validation errors",
            ["errors" => $errors]
        );
    }

    $stmt = $con->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        http_response_code(409);
        responseJson(
            "failed",
            "email already exists"
        );
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(16));
    $stmt = $con->prepare("INSERT INTO users (`username`,`email`,`password`,`is_active`,`verification_token`) VALUES (?,?,?,0,?)");
    $stmt->execute([$username, $email, $hashed, $token]);

    if (sendVerificationEmail($email, $username, $token)) {
        echo "Email sent successfully!";
    } else {
        echo "Failed to send email.";
    }
    http_response_code(201);

    responseJson(
        "success",
        "user registered success",
        ["id" => $con->lastInsertId(), "email" => $email, "token" => $token]
    );

} catch (Exception $e) {
    error_log("Register error: " . $e->getMessage());
    http_response_code(500);
    responseJson("error", "Server error");
}