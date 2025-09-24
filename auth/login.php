<?php
include "../connectDB.php";
include "../functions.php";

header("Content-Type: application/json");

try {

    $username = filterRequest("username");
    $email = filterRequest("email");
    $password = filterRequest("password");

    $stmt = $con->prepare(
        "SELECT * FROM `users` WHERE `password` = ? AND `email` = ? "
    );

    $stmt->execute(array($email, $password));

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
        "message" => "server error"
    ]);

}
