<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Handle CORS preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../config/supabase.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Only POST requests are allowed"
    ]);
    exit();
}

// Read JSON request body
$input = file_get_contents("php://input");
$data = json_decode($input);

// Check JSON
if ($data === null) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Invalid JSON data"
    ]);
    exit();
}

// Get form data
$name = trim($data->name ?? '');
$phone = trim($data->phone ?? '');
$date = trim($data->date ?? '');
$message = trim($data->message ?? '');

// Basic validation
if ($name === '' || $phone === '' || $date === '') {
    http_response_code(400);

    echo json_encode([
        "status" => "error",
        "message" => "Name, phone and date are required"
    ]);

    exit();
}

// Supabase REST API endpoint
$url = SUPABASE_URL . '/rest/v1/appointments';

// Data to insert
$payload = json_encode([
    "name" => $name,
    "phone" => $phone,
    "date" => $date,
    "message" => $message
]);

// Initialize cURL
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . SUPABASE_KEY,
    'Content-Type: application/json',
    'Prefer: return=minimal'
]);

// Execute request
$response = curl_exec($ch);

// Handle cURL error
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

// Get HTTP status
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

// Successful insertion
if ($httpCode >= 200 && $httpCode < 300) {

    echo json_encode([
        "status" => "success",
        "message" => "Appointment booked successfully"
    ]);

    exit();
}

// Supabase returned an error
http_response_code($httpCode);

echo json_encode([
    "status" => "error",
    "message" => "Failed to book appointment",
    "supabase_response" => json_decode($response)
]);

?>