<?php
session_start();

// Check if the user is already logged in, redirect to the home page
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: delete-influxdb2.php');
    exit;
}

// Define the valid username and hashed password
$valid_username = 'your_username';
$valid_password_hash = 'your_hashed_password';

// Error message variables
$username_error = $password_error = $login_error = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted username and password
    $username = clean_input($_POST['username']);
    $password = $_POST['password'];

    // Validate the username
    if (empty($username)) {
        $username_error = 'Username is required.';
    }

    // Validate the password
    if (empty($password)) {
        $password_error = 'Password is required.';
    }

    // If both fields are filled, proceed with authentication
    if (!empty($username) && !empty($password)) {
        // Verify the username and hashed password
        if ($username === $valid_username && password_verify($password, $valid_password_hash)) {
            // Set the 'logged_in' session variable to true
            $_SESSION['logged_in'] = true;

            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            // Set secure session cookie flag
            ini_set('session.cookie_secure', 1);

            // Set appropriate session timeout (e.g., 15 minutes)
            $_SESSION['timeout'] = time() + 86.400; // 900 seconds = 15 minutes

            // Redirect to the home page
            header('Location: delete-influxdb2.php');
            exit;
        } else {
            // Invalid username or password
            $login_error = 'Invalid username or password.';
        }
    }
}

// Function to clean user input
function clean_input($input)
{
    // Trim whitespace
    $input = trim($input);
    // Remove backslashes
    $input = stripslashes($input);
    // Convert special characters to HTML entities
    $input = htmlspecialchars($input);
    return $input;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Login</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="text-center">
                <input type="submit" value="Login" class="btn btn-primary">
            </div>
            <p class="error-message text-center"><?php echo $login_error; ?></p>
        </form>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>

