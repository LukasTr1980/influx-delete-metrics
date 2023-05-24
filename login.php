<?php
session_start();

// Check if the user is already logged in, redirect to the home page
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: home.php');
    exit;
}

// Define the valid username and password
$valid_username = 'your_username';
$valid_password = 'your_password';

// Error message variables
$username_error = $password_error = $login_error = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted username and password
    $username = $_POST['username'];
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
        // Validate the username and password
        if ($username === $valid_username && $password === $valid_password) {
            // Set the 'logged_in' session variable to true
            $_SESSION['logged_in'] = true;

            // Redirect to the home page
            header('Location: home.php');
            exit;
        } else {
            // Invalid username or password
            $login_error = 'Invalid username or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <p style="color: red;"><?php echo $username_error; ?></p>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <p style="color: red;"><?php echo $password_error; ?></p>
        </div>
        <div>
            <input type="submit" value="Login">
        </div>
        <p style="color: red;"><?php echo $login_error; ?></p>
    </form>
</body>
</html>
