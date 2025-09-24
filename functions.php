<?php

function getJsonInput()
{
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(
            [
                "status" => "failed",
                "message" => "Invalid JSON format"
            ],
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
        exit;
    }
    return $data ?? [];
}

function filterRequest($key)
{
    $data = getJsonInput();
    return isset($data[$key]) ? htmlspecialchars(strip_tags($data[$key])) : null;
}
;


function responseJson($status, $message, $data = null)
{
    header("Content-Type: application/json");
    echo json_encode(
        [
            "status" => $status,
            "message" => $message,
            "data" => $data
        ],
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
    exit;
}