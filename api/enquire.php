<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../config/supabase.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode([
        "status" => "error",
        "message" => "Only POST requests are allowed"
    ]);

    exit();
}

$input = file_get_contents("php://input");
$data = json_decode($input);

if ($data === null) {
    http_response_code(400);

    echo json_encode([
        "status" => "error",
        "message" => "Invalid JSON data"
    ]);

    exit();
}

$name = trim($data->name ?? '');
$email = trim($data->email ?? '');
$phone = trim($data->phone ?? '');
$message = trim($data->message ?? '');

if ($name === '' || $email === '' || $phone === '') {
    http_response_code(400);

    echo json_encode([
        "status" => "error",
        "message" => "Name, email and phone are required"
    ]);

    exit();
}

$url = SUPABASE_URL . '/rest/v1/enquiries';

$payload = json_encode([
    "name" => $name,
    "email" => $email,
    "phone" => $phone,
    "message" => $message
]);

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . SUPABASE_KEY,
    'Content-Type: application/json',
    'Prefer: return=minimal'
]);

$response = curl_exec($ch);

if ($response === false) {

    $error = curl_error($ch);

    curl_close($ch);

    http_response_code(500);

    echo json_encode([
        "status" => "error",
        "message" => "Supabase connection error",
        "details" => $error
    ]);

    exit();
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($httpCode >= 200 && $httpCode < 300) {

    echo json_encode([
        "status" => "success",
        "message" => "Enquiry submitted successfully"
    ]);

    exit();
}

http_response_code($httpCode);

echo json_encode([
    "status" => "error",
    "message" => "Failed to submit enquiry",
    "supabase_response" => json_decode($response)
]);

?>