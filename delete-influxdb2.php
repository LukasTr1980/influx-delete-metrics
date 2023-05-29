<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page or display access denied message
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete InfluxDB2 Metrics</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container border p-4 mt-5">
        <h1 class="text-center">Delete InfluxDB2 Metrics</h1>
        <form action="delete_data.php" method="post">
          <div class="mb-3">
            <label for="org" class="form-label"><b>Organization:</b></label>
            <input type="text" id="org" name="org" class="form-control" value="villaanna">
          </div>
          <div class="mb-3">
            <label for="bucket" class="form-label"><b>Bucket:</b></label>
            <input type="text" id="bucket" name="bucket" class="form-control" value="iobroker">
          </div>
            <div class="mb-3">
                <label for="start" class="form-label"><b>Start:</b></label>
                <input type="text" id="start" name="start" class="form-control" placeholder="YYYY-MM-DDTHH:MM:SSZ">
            </div>
            <div class="mb-3">
                <label for="stop" class="form-label"><b>Stop:</b></label>
                <input type="text" id="stop" name="stop" class="form-control" placeholder="YYYY-MM-DDTHH:MM:SSZ">
            </div>
            <div class="mb-3">
                <label for="measurement" class="form-label"><b>Measurement:</b></label>
                <input type="text" id="measurement" name="measurement" class="form-control">
            </div>
            <div class="mb-3">
                <label for="api_token" class="form-label"><b>API Token:</b></label>
                <input type="text" id="api_token" name="api_token" class="form-control">
            </div>
            <input type="submit" value="Submit" class="btn btn-primary">
        </form>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
