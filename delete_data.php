<?php
session_start();

// Check if user is not logged in or if the request is not a POST request
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Redirect to login page or display access denied message
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Delete Data</h1>
        <a href="login.php" class="btn btn-secondary">&lt;&lt; Back to Login</a>

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
$http_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE); // Get the HTTP response code

// Output the cURL command sent
$info = curl_getinfo($ch);
$curl_command = "curl -X POST -H 'Authorization: Token $api_token' -H 'Content-Type: application/json' -d '" . json_encode($data) . "' " . $info['url'];
echo '<div class="alert alert-info" role="alert">' . $curl_command . '</div>';

curl_close($ch);

if ($output === false) {
    echo '<div class="alert alert-danger" role="alert">cURL Error: ' . $error . '</div>';
} else {
    if ($http_code >= 200 && $http_code < 300) {
        echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($output) . '</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">HTTP Error ' . $http_code . ': ' . htmlspecialchars($output) . '</div>';
    }
}
?>

 </div>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>