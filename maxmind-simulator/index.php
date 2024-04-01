<?php

echo 123;
die;

// Capture POST data
$postData = file_get_contents('php://input');
$request = json_decode($postData, true);

// Generate a unique hash based on the request payload
$hash = hash('sha256', $postData);

// Use the hash to generate a pseudo-random but consistent "risk_score" for each unique request
srand(hexdec(substr($hash, 0, 8))); // Seed with a portion of the hash
$riskScore = rand(10, 10000) / 100; // Generate a number between 0.1 and 100

// Predefined response structure
$response = [
    "risk_score" => $riskScore,
    "id" => "27d26476-e2bc-11e4-92b8-962e705b4af5",
    "funds_remaining" => 10.00,
    "queries_remaining" => 1000,
    "disposition" => [
        "action" => "reject",
        "reason" => "custom_rule"
    ],
    "ip_address" => [
        "risk" => 99.00
    ]
];

// Ensure that the seed is not predictable by resetting it
srand();

// Send the response
header('Content-Type: application/json');
echo json_encode($response);
