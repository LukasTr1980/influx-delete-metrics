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
// Read the token from the JSON file
$tokenFile = '/var/www/html/passwd/influx-read-buckets-token.json';
$tokenData = file_get_contents($tokenFile);
$tokenJson = json_decode($tokenData, true);
$token = $tokenJson['token'];

// Set the InfluxDB server URL and organization name
$influxUrl = 'http://localhost:8086';
$org = 'villaanna';

// Set the API endpoint to retrieve the buckets
$apiEndpoint = "/api/v2/buckets?org={$org}";

// Set the curl command to retrieve the buckets
$curlCommand = "curl --header 'Authorization: Token {$token}' '{$influxUrl}{$apiEndpoint}'";

// Execute the curl command and capture the output
$output = shell_exec($curlCommand);

// Parse the output as JSON
$buckets = json_decode($output, true);

// Extract the bucket names
$bucketNames = array_column($buckets['buckets'], 'name');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete InfluxDB2 Metrics</title>
    <!-- Include meta viewport tag for responsive page -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container border p-4 mt-5">
        <h1 class="text-center">Delete InfluxDB2 Metrics</h1>
        <form action="delete_data.php" method="post" id="delete-form">
          <div class="mb-3 form-group">
            <label for="org"><b>Organization:</b></label>
            <input type="text" id="org" name="org" class="form-control" value="villaanna" required>
          </div>
          <div class="mb-3 form-group">
            <label for="bucket"><b>Bucket:</b></label>
            <select id="bucket" name="bucket" class="form-control" required>
              <option value="" disabled selected>Select a bucket</option>
              <?php foreach ($bucketNames as $bucketName) { ?>
                <option value="<?php echo $bucketName; ?>"><?php echo $bucketName; ?></option>
              <?php } ?>
            </select>
          </div>
            <div class="mb-3 form-group">
                <label for="start"><b>Start:</b></label>
                <input type="text" id="start" name="start" class="form-control" placeholder="YYYY-MM-DDTHH:MM:SSZ - Input time converts to UTC" required>
            </div>
            <div class="mb-3 form-group">
                <label for="stop"><b>Stop:</b></label>
                <input type="text" id="stop" name="stop" class="form-control" placeholder="YYYY-MM-DDTHH:MM:SSZ - Input time converts to UTC" required>
            </div>
            <div class="mb-3 form-group">
                <label for="measurement"><b>Measurement:</b></label>
                <input type="text" id="measurement" name="measurement" class="form-control" required>
            </div>
            <div class="mb-3 form-group">
                <label for="api_token"><b>API Token:</b></label>
                <input type="text" id="api_token" name="api_token" class="form-control" required>
            </div>
            <input type="submit" value="Submit" class="btn btn-primary">
        </form>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <script>
        const startInput = document.getElementById('start');
        const stopInput = document.getElementById('stop');
        const deleteForm = document.getElementById('delete-form');

        // Add event listener to start input
        startInput.addEventListener('input', () => {
            const value = startInput.value;
            const regex = new RegExp('^' + preg_quote('\\d{4}-\\d{2}-\\d{2}T\\d{2}:\\d{2}:\\d{2}Z') + '$');
            if (regex.test(value)) {
                startInput.classList.remove('is-invalid');
                startInput.classList.add('is-valid');
            } else {
                startInput.classList.remove('is-valid');
                startInput.classList.add('is-invalid');
            }
        });

        // Add event listener to stop input
        stopInput.addEventListener('input', () => {
            const value = stopInput.value;
            const regex = new RegExp('^' + preg_quote('\\d{4}-\\d{2}-\\d{2}T\\d{2}:\\d{2}:\\d{2}Z') + '$');
            if (regex.test(value)) {
                stopInput.classList.remove('is-invalid');
                stopInput.classList.add('is-valid');
            } else {
                stopInput.classList.remove('is-valid');
                stopInput.classList.add('is-invalid');
            }
        });

        // Add event listener to form submit
        deleteForm.addEventListener('submit', (event) => {
            const startValue = startInput.value;
            const stopValue = stopInput.value;
            const regex = new RegExp('^' + preg_quote('\\d{4}-\\d{2}-\\d{2}T\\d{2}:\\d{2}:\\d{2}Z') + '$');
            if (!regex.test(startValue) || !regex.test(stopValue)) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>