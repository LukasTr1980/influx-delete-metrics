<?php
session_start();

// Check if user is not logged in or if the request is not a POST request
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SERVER['REQUEST_METHOD'] !== 'POST') {
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

$endpoint = "http://localhost:8086/api/v2/delete?org=$org&bucket=$bucket";
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
$error = curl_error($ch); // Get any errors that occurred during the request

// Output the cURL command sent
$info = curl_getinfo($ch);
$curl_command = "curl -X POST -H 'Authorization: Token $api_token' -H 'Content-Type: application/json' -d '" . json_encode($data) . "' " . $info['url'];
echo "cURL Command: $curl_command<br><br>";

curl_close($ch);

if ($output === false) {
    echo 'cURL Error: ' . $error;
} else {
    echo htmlspecialchars($output);
}
?>