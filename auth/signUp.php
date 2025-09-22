<?php

include "../connectDB.php";
include "../functions.php";

$username = filterRequest("username") ?? null;
$email = filterRequest("email") ?? null;
$password = filterRequest("password") ?? null;

$stmt = $con->prepare(
    "INSERT INTO `users`( `username`, `email`, `password`) VALUES (?,?,?)"
);

$stmt->execute(
    array($username, $email, $password)
);

$count = $stmt->rowCount();

if ($count > 0) {
    http_response_code(200);
    echo json_encode(array(
        "status" => "success"
    ));
} else {
    http_response_code(400);
    echo json_encode(array(
        "status" => "filer"
    ));
}