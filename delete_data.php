<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page or display access denied message
    header('Location: login.php');
    exit;
}
?>

<?php
// delete_data.php
$org = filter_input(INPUT_POST, 'org', FILTER_SANITIZE_STRING);
$bucket = filter_input(INPUT_POST, 'bucket', FILTER_SANITIZE_STRING);
$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
$stop = filter_input(INPUT_POST, 'stop', FILTER_SANITIZE_STRING);
$measurement = filter_input(INPUT_POST, 'measurement', FILTER_SANITIZE_STRING);
$api_token = filter_input(INPUT_POST, 'api_token', FILTER_SANITIZE_STRING);

$endpoint = 'https://localhost:8086/api/v2/delete';
$headers = [
    'Authorization: Token ' . $api_token,
    'Content-Type: application/json'
];
$data = [
    'start' => $start,
    'stop' => $stop,
    'predicate' => "_measurement=\"$measurement\""
];

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$output = curl_exec($ch);
curl_close($ch);

echo htmlspecialchars($output);
?>
