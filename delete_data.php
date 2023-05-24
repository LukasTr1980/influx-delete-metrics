<?php
// delete_data.php
$org = filter_input(INPUT_POST, 'org', FILTER_SANITIZE_STRING);
$bucket = filter_input(INPUT_POST, 'bucket', FILTER_SANITIZE_STRING);
$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
$stop = filter_input(INPUT_POST, 'stop', FILTER_SANITIZE_STRING);
$measurement = filter_input(INPUT_POST, 'measurement', FILTER_SANITIZE_STRING);
$api_token = filter_input(INPUT_POST, 'api_token', FILTER_SANITIZE_STRING);

$command = "curl --request POST https://localhost:8086/api/v2/delete?org=$org&bucket=$bucket \
--header 'Authorization: Token $api_token' \
--header 'Content-Type: application/json' \
--data '{ \"start\": \"$start\", \"stop\": \"$stop\", \"predicate\": \"_measurement=\\\"$measurement\\\"\" }'";
$output = shell_exec($command);
echo htmlspecialchars($output);
?>