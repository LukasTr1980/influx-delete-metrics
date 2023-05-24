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
<style>
  body {
    font-family: Arial, sans-serif;
  }
  form {
    margin: 0 auto;
    width: 300px;
    padding: 1em;
    border: 1px solid #CCC;
    border-radius: 1em;
  }
  label {
    display: inline-block;
    width: 90px;
    text-align: right;
  }
  input[type="text"] {
    font: 1em sans-serif;
    width: 130px;
    box-sizing: border-box;
    border: 1px solid #999;
  }
  input[type="submit"] {
    margin-left: 120px;
    padding: .5em .75em;
    font-size: .8em;
    border-radius: .5em;
    background-color: #4CAF50;
    color: white;
    border: none;
  }
</style>

<form action="delete_data.php" method="post">
  <label for="org">Organization:</label>
  <input type="text" id="org" name="org"><br><br>
  <label for="bucket">Bucket:</label>
  <input type="text" id="bucket" name="bucket"><br><br>
  <label for="start">Start:</label>
  <input type="text" id="start" name="start"><br><br>
  <label for="stop">Stop:</label>
  <input type="text" id="stop" name="stop"><br><br>
  <label for="measurement">Measurement:</label>
  <input type="text" id="measurement" name="measurement"><br><br>
  <label for="api_token">API Token:</label>
  <input type="text" id="api_token" name="api_token"><br><br>
  <input type="submit" value="Submit">
</form>
