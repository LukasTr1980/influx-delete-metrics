<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page or display access denied message
    header('Location: login.php');
    exit;
}
?>

<!-- delete-influxdb2.html -->
<!DOCTYPE html>
<html>
<head>
    <title>Delete Data</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form action="delete_data.php" method="post">
            <div class="mb-3">
                <label for="org" class="form-label">Organization:</label>
                <input type="text" id="org" name="org" class="form-control">
            </div>
            <div class="mb-3">
                <label for="bucket" class="form-label">Bucket:</label>
                <input type="text" id="bucket" name="bucket" class="form-control">
            </div>
            <div class="mb-3">
                <label for="start" class="form-label">Start:</label>
                <input type="text" id="start" name="start" class="form-control">
            </div>
            <div class="mb-3">
                <label for="stop" class="form-label">Stop:</label>
                <input type="text" id="stop" name="stop" class="form-control">
            </div>
            <div class="mb-3">
                <label for="measurement" class="form-label">Measurement:</label>
                <input type="text" id="measurement" name="measurement" class="form-control">
            </div>
            <div class="mb-3">
                <label for="api_token" class="form-label">API Token:</label>
                <input type="text" id="api_token" name="api_token" class="form-control">
            </div>
            <input type="submit" value="Submit" class="btn btn-primary">
        </form>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
