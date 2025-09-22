<?php
include "../connectDB.php";
include "../functions.php";

header("Content-Type: application/json");

try {
    $data = json_decode(file_get_contents("php://input"), true);

    $username = filterRequest($data["username"] ?? null);
    $email = filterRequest($data["email"] ?? null);
    $password = filterRequest($data["password"] ?? null);

    $stmt = $con->prepare(
        "INSERT INTO `users` (`username`, `email`, `password`) VALUES (?,?,?)"
    );

    $stmt->execute([$username, $email, $password]);

    if ($stmt->rowCount() > 0) {
        http_response_code(201);
        echo json_encode(["status" => "success"]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "failed"]);
    }

} catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $th->getMessage()
    ]);
}
