<?php

include __DIR__ . "/../connectDB.php";
include __DIR__ . "/../functions.php";

header("Content-Type: application/json; charset=utf-8");

try {
    $token = isset($_GET['token']) ? $_GET['token'] : null;
    if (!$token) {
        http_response_code(400);
        responseJson("failed", "token is missing");
    }
    $stmt = $con->prepare("SELECT id ,is_active FROM users WHERE verification_token = ? LIMIT 1");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        http_response_code(404);
        responseJson("failed", "Invalid  token");

    }
    if ($user["is_active"] == 1) {
        responseJson("success", "User already verified");
    }

    $stmt = $con->prepare("UPDATE users SET is_active=1,verification_token = NULL WHERE id = ?");
    $stmt->execute([$user['id']]);

    responseJson("success", "User verified successfully");

} catch (Exception $e) {
    error_log("Verify error: " . $e->getMessage());
    http_response_code(500);
    responseJson("error", "Server error");
}