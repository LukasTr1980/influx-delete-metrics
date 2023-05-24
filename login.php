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
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);

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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        p.error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST" action="">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <input type="submit" value="Login">
            </div>
            <p class="error-message"><?php echo $login_error; ?></p>
        </form>
    </div>
</body>
</html>
